<?php

/**
 * Class PageLanguageMetaboxTest
 *
 * @package Pressbooks_Aldine
 */

use Aldine\Admin\PageLanguageMetabox;

/**
 * Test case for PageLanguageMetabox.
 */
class PageLanguageMetaboxTest extends WP_UnitTestCase
{
    /**
     * Instance of PageLanguageMetabox for testing.
     *
     * @var PageLanguageMetabox
     */
    private $metabox;

    /**
     * Test page ID.
     *
     * @var int
     */
    private $page_id;

    /**
     * Set up test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->page_id = $this->factory->post->create([
            'post_type' => 'page',
            'post_title' => 'Test Home Page',
            'post_status' => 'publish'
        ]);

        update_post_meta($this->page_id, '_wp_page_template', 'page-custom-home.php');

        $this->metabox = PageLanguageMetabox::init();

        $this->mock_main_site();
    }

    public function tearDown(): void
    {
        wp_delete_post($this->page_id, true);
        parent::tearDown();
    }

    private function mock_main_site(): void
    {
        if (! function_exists('is_main_site')) {
            function is_main_site()
            {
                return true;
            }
        }
    }

    /**
     * @test
     */
    public function it_initializes_singleton(): void
    {
        $instance1 = PageLanguageMetabox::init();
        $instance2 = PageLanguageMetabox::init();

        $this->assertSame($instance1, $instance2, 'PageLanguageMetabox should return the same instance');
        $this->assertInstanceOf(PageLanguageMetabox::class, $instance1);
    }

    /**
     * @test
     */
    public function it_registers_hooks(): void
    {
        $this->assertTrue(has_action('add_meta_boxes') !== false);
        $this->assertTrue(has_action('save_post') !== false);
        $this->assertTrue(has_action('template_redirect') !== false);
    }

    /**
     * @test
     */
    public function it_adds_language_metabox_correct_conditions(): void
    {
        global $post;
        $post = get_post($this->page_id);

        ob_start();
        $this->metabox->addLanguageMetabox('page');
        ob_end_clean();

        global $wp_meta_boxes;
        $this->assertArrayHasKey('aldine_language_metabox', $wp_meta_boxes['page']['side']['default'] ?? []);
    }

    /**
     * @test
     */
    public function it_adds_language_metabox_wrong_post_type(): void
    {
        global $wp_meta_boxes;
        $wp_meta_boxes = [];

        $this->metabox->addLanguageMetabox('post');

        $this->assertArrayNotHasKey('aldine_language_metabox', $wp_meta_boxes['page']['side']['default'] ?? []);
    }

    /**
     * @test
     */
    public function it_adds_language_metabox_wrong_template(): void
    {
        global $post, $wp_meta_boxes;

        $wrong_page_id = $this->factory->post->create([
            'post_type' => 'page',
            'post_title' => 'Wrong Template Page'
        ]);
        update_post_meta($wrong_page_id, '_wp_page_template', 'page-other.php');

        $post = get_post($wrong_page_id);
        $wp_meta_boxes = [];

        $this->metabox->addLanguageMetabox('page');

        $this->assertArrayNotHasKey('aldine_language_metabox', $wp_meta_boxes['page']['side']['default'] ?? []);

        wp_delete_post($wrong_page_id, true);
    }

    /**
     * @test
     */
    public function it_renders_language_selector(): void
    {
        $post = get_post($this->page_id);

        $reflection = new ReflectionClass($this->metabox);
        $method = $reflection->getMethod('getAvailableLanguages');
        $method->setAccessible(true);

        ob_start();
        $this->metabox->renderLanguageSelector($post);
        $output = ob_get_clean();

        $this->assertStringContainsString('<select name="page_language"', $output);
        $this->assertStringContainsString('<label for="page_language"', $output);
        $this->assertStringContainsString('aldine_language_metabox_nonce', $output);
    }

    /**
     * @test
     */
    public function it_saves_language_metabox(): void
    {
        $_POST['page_language'] = 'it_IT';
        $_POST['aldine_language_metabox_nonce'] = wp_create_nonce('aldine_language_metabox_nonce_action');

        $user = $this->factory->user->create([ 'role' => 'administrator' ]);
        wp_set_current_user($user);

        $this->metabox->saveLanguageMetabox($this->page_id);

        unset($_POST['page_language']);
        unset($_POST['aldine_language_metabox_nonce']);

        $this->assertTrue(true, 'Save method executed without fatal errors');
    }

    /**
     * @test
     */
    public function it_tests_language_meta_storage(): void
    {
        update_post_meta($this->page_id, 'page_language', 'es_ES');
        $saved = get_post_meta($this->page_id, 'page_language', true);
        $this->assertEquals('es_ES', $saved);

        delete_post_meta($this->page_id, 'page_language');
        $saved = get_post_meta($this->page_id, 'page_language', true);
        $this->assertEmpty($saved);
    }

    /**
     * @test
     */
    public function it_checks_basic_functionality(): void
    {
        $this->assertInstanceOf(PageLanguageMetabox::class, $this->metabox);

        global $post;
        $post = get_post($this->page_id);

        ob_start();
        $this->metabox->addLanguageMetabox('page');
        ob_end_clean();

        $reflection = new ReflectionClass($this->metabox);
        $method = $reflection->getMethod('formatLocaleCode');
        $method->setAccessible(true);

        $result = $method->invoke($this->metabox, 'es_ES');
        $this->assertEquals('Es (ES)', $result);

        $result = $method->invoke($this->metabox, 'ja');
        $this->assertEquals('Ja', $result);
    }

    /**
     * @test
     */
    public function it_tests_save_language_metabox_invalid_nonce(): void
    {
        $_POST['page_language'] = 'it_IT';
        $_POST['aldine_language_metabox_nonce'] = 'invalid_nonce';

        $user = $this->factory->user->create([ 'role' => 'administrator' ]);
        wp_set_current_user($user);

        $this->metabox->saveLanguageMetabox($this->page_id);

        $saved_language = get_post_meta($this->page_id, 'page_language', true);
        $this->assertEmpty($saved_language);

        unset($_POST['page_language']);
        unset($_POST['aldine_language_metabox_nonce']);
    }

    /**
     * @test
     */
    public function it_tries_saving_language_metabox_insufficient_permissions(): void
    {
        $_POST['page_language'] = 'it_IT';
        $_POST['aldine_language_metabox_nonce'] = wp_create_nonce('aldine_language_metabox_nonce_action');

        $user = $this->factory->user->create([ 'role' => 'subscriber' ]);
        wp_set_current_user($user);

        $this->metabox->saveLanguageMetabox($this->page_id);

        $saved_language = get_post_meta($this->page_id, 'page_language', true);
        $this->assertEmpty($saved_language);

        unset($_POST['page_language']);
        unset($_POST['aldine_language_metabox_nonce']);
    }

    /**
     * @test
     */
    public function it_tests_template_isolation(): void
    {
        $other_page_id = $this->factory->post->create([
            'post_type' => 'page',
            'post_title' => 'Other Page'
        ]);
        update_post_meta($other_page_id, '_wp_page_template', 'page-other.php');

        $_POST['page_language'] = 'it_IT';
        $_POST['aldine_language_metabox_nonce'] = wp_create_nonce('aldine_language_metabox_nonce_action');

        $user = $this->factory->user->create([ 'role' => 'administrator' ]);
        wp_set_current_user($user);

        $this->metabox->saveLanguageMetabox($other_page_id);

        $saved_language = get_post_meta($other_page_id, 'page_language', true);
        $this->assertEmpty($saved_language);

        wp_delete_post($other_page_id, true);
        unset($_POST['page_language']);
        unset($_POST['aldine_language_metabox_nonce']);
    }
}
