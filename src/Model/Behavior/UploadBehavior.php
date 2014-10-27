<?php
namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;

class UploadBehavior extends Behavior {

/**
 * Default config.
 *
 * @var array
 */
	protected $_defaultConfig = [
		'root' => WWW_ROOT,
		'suffix' => '_file',
		'fields' => []
	];

/**
 * Table instance.
 *
 * @var \Cake\ORM\Table
 */
	protected $_table;

/**
 * Folder instance.
 *
 * @var \Cake\Filesystem\Folder
 */
	protected $_folder;

/**
 * Overwrite all file on upload.
 *
 * @var bool
 */
	protected $_overwrite = true;

/**
 * The prefix of the file.
 *
 * @var bool|string
 */
	protected $_prefix = false;

/**
 * The default file of the field.
 *
 * @var bool|string
 */
	protected $_defaultFile = false;

/**
 * Check if there is some files to upload and modify the entity before
 * it is saved.
 *
 * At the end, for each files to upload, unset their "virtual" property.
 *
 * @param Event  $event  The beforeSave event that was fired.
 * @param Entity $entity The entity that is going to be saved.
 *
 * @throws \LogicException When the path configuration is not set.
 * @throws \ErrorException When the function to get the upload path failed.
 *
 * @return void
 */
	public function beforeSave(Event $event, Entity $entity) {
		$config = $this->_config;

		foreach ($config['fields'] as $field => $fieldOption) {

			$data = $entity->toArray();
			$virtualField = $field . $config['suffix'];

			if (!isset($data[$virtualField]) || !is_array($data[$virtualField])) {
				continue;
			}

			$file = $entity->get($virtualField);

			if ((int)$file['error'] === UPLOAD_ERR_NO_FILE) {
				continue;
			}

			if (!isset($fieldOption['path'])) {
				throw new \LogicException(__('The path for the {0} field is required.', $field));
			}

			if (isset($fieldOption['prefix']) && (is_bool($fieldOption['prefix']) || is_string($fieldOption['prefix']))) {
				$this->_prefix = $fieldOption['prefix'];
			}

			$extension = (new File($file['name'], false))->ext();

			$uploadPath = $this->_getUploadPath($entity, $fieldOption['path'], $extension);

			if (!$uploadPath) {
				throw new \ErrorException(__('Error to get the uploadPath.'));
			}

			$folder = new Folder($this->_config['root']);
			$folder->create($this->_config['root'] . dirname($uploadPath));

			if ($this->_moveFile($entity, $file['tmp_name'], $uploadPath, $field, $fieldOption)) {

				if (!$this->_prefix) {
					$this->_prefix = '';
				}

				$entity->set($field, $this->_prefix . $uploadPath);

			}

			$entity->unsetProperty($virtualField);
		}
	}

/**
 * Move the temporary source file to the destination file.
 *
 * @param \Cake\ORM\Entity $entity      The entity that is going to be saved.
 * @param bool|string      $source      The temporary source file to copy.
 * @param bool|string      $destination The destination file to copy.
 * @param bool|string      $field       The current field to process.
 * @param array            $options     The configuration options defined by the user.
 *
 * @return bool
 */
	protected function _moveFile(Entity $entity, $source = false, $destination = false, $field = false, array $options = []) {
		if ($source === false || $destination === false || $field === false) {
			return false;
		}

		if (isset($options['overwrite']) && is_bool($options['overwrite'])) {
			$this->_overwrite = $options['overwrite'];
		}

		$file = new File($source, false, 0755);

		if ($this->_overwrite) {
			$this->_deleteOldUpload($entity, $field, $destination, $options);
		}

		if ($file->copy($this->_config['root'] . $destination, $this->_overwrite)) {
			return true;
		}

		return false;
	}

/**
 * Delete the old upload file before to save the new file.
 *
 * We can not just rely on the copy file with the overwrite, because if you use
 * an identifier like :md5 (Who use a different name for each file), the copy
 * function will not delete the old file.
 *
 * @param \Cake\ORM\Entity $entity  The entity that is going to be saved.
 * @param bool|string      $field   The current field to process.
 * @param bool|string      $newFile The new file path.
 * @param array            $options The configuration options defined by the user.
 *
 * @return bool
 */
	protected function _deleteOldUpload(Entity $entity, $field = false, $newFile = false, array $options = []) {
		if ($field === false || $newFile === false) {
			return true;
		}

		$fileInfo = pathinfo($entity->$field);
		$newFileInfo = pathinfo($newFile);

		if (isset($options['defaultFile']) && (is_bool($options['defaultFile']) || is_string($options['defaultFile']))) {
			$this->_defaultFile = $options['defaultFile'];
		}

		if ($fileInfo['basename'] == $newFileInfo['basename'] || $fileInfo['basename'] == $this->_defaultFile) {
			return true;
		}

		if ($this->_prefix) {
			$entity->$field = str_replace($this->_prefix, "", $entity->$field);
		}

		$file = new File($entity->$field, false);

		if ($file->exists()) {
			$file->delete();

			return true;
		}

		return false;
	}

/**
 * Get the path formatted without its identifiers to upload the file.
 *
 * Identifiers :
 *      :id  : Id of the Entity.
 *      :md5 : A random and unique identifier with 32 characters.
 *      :y   : Based on the current year.
 *      :m   : Based on the current month.
 *
 * i.e : upload/:id/:md5 -> upload/2/5e3e0d0f163196cb9526d97be1b2ce26.jpg
 *
 * @param \Cake\ORM\Entity $entity    The entity that is going to be saved.
 * @param bool|string      $path      The path to upload the file with its identifiers.
 * @param bool|string      $extension The extension of the file.
 *
 * @return string|void
 */
	protected function _getUploadPath(Entity $entity, $path = false, $extension = false) {
		if ($extension === false || $path === false) {
			return false;
		}

		$path = trim($path, DS);

		$identifiers = [
			':id' => $entity->id,
			':md5' => md5(rand() . uniqid() . time()),
			':y' => date('Y'),
			':m' => date('m')

		];

		return strtr($path, $identifiers) . '.' . strtolower($extension);
	}
}
