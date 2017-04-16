<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class AttachmentsControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.aros',
        'app.acos',
        'app.aros_acos',
        'app.blog_attachments',
        'app.groups',
        'app.groups_i18n',
        'app.notifications',
        'app.settings',
        'app.sessions',
        'app.users',
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownload()
    {
        $this->get(['controller' => 'attachments', 'action' => 'download', 'type' => 'blog', 'id' => 1]);
        $this->assertResponseOk();
        $this->assertHeader('Content-Disposition', 'attachment; filename="Attachment.zip"');
        $this->assertHeader('Content-Type', 'application/zip');
        $this->assertHeader('Content-Transfer-Encoding', 'binary');
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownloadNotFound()
    {
        $this->get(['controller' => 'attachments', 'action' => 'download', 'type' => 'blog', 'id' => 1337]);
        $this->assertResponseError();
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownloadNotConnected()
    {
        $this->session([
            'Auth' => []
        ]);
        $this->get(['controller' => 'attachments', 'action' => 'download', 'type' => 'blog', 'id' => 1]);
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'users', 'action' => 'login', 'redirect' => '/attachments/download/blog/1']);
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownloadWrongType()
    {
        $this->get(['controller' => 'attachments', 'action' => 'download', 'type' => 'blog2', 'id' => 1]);
        $this->assertResponseError();
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownloadFileNotFound()
    {
        $this->get(['controller' => 'attachments', 'action' => 'download', 'type' => 'blog', 'id' => 2]);
        $this->assertResponseError();
    }
}
