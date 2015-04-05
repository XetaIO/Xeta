<?php
namespace App\Model\Behavior;

trait AppTranslateTrait
{

    /**
     * Set the transaltions to be saved.
     *
     * @param array $data The data to save.
     *
     * @return void
     */
    public function setTranslations($data = [])
    {
        if (array_key_exists('translations', $data)) {
            foreach ($data['translations'] as $locale => $dataLocale) {
                $this->translation($locale)->set($dataLocale, ['guard' => false]);
            }
        }
    }
}
