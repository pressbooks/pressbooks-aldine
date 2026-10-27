<?php

/**
 * Catalog tests.
 */

use Aldine\Admin\Catalog;
use Pressbooks\DataCollector\Book as BookDataCollector;

class CatalogTest extends WP_UnitTestCase
{
    public function set_up()
    {
        parent::set_up();

        if (! is_multisite()) {
            $this->markTestSkipped('Multisite is required.');
        }
    }

    public function test_set_catalog_status_adds_public_book()
    {
        $blog_id = $this->factory()->blog->create();
        update_blog_option($blog_id, 'blog_public', 1);

        $this->assertTrue(Catalog::setCatalogStatus($blog_id, true));
        $this->assertSame(1, (int) get_blog_option($blog_id, \Aldine\Admin\BLOG_OPTION));
        $this->assertSame('1', get_site_meta($blog_id, BookDataCollector::IN_CATALOG, true));
    }

    public function test_set_catalog_status_removes_book()
    {
        $blog_id = $this->factory()->blog->create();
        update_blog_option($blog_id, 'blog_public', 1);
        Catalog::setCatalogStatus($blog_id, true);

        $this->assertTrue(Catalog::setCatalogStatus($blog_id, false));
        $this->assertFalse(get_blog_option($blog_id, \Aldine\Admin\BLOG_OPTION));
        $this->assertSame('0', get_site_meta($blog_id, BookDataCollector::IN_CATALOG, true));
    }

    public function test_set_catalog_status_skips_private_book()
    {
        $blog_id = $this->factory()->blog->create();
        update_blog_option($blog_id, 'blog_public', 0);

        $this->assertFalse(Catalog::setCatalogStatus($blog_id, true));
        $this->assertFalse(get_blog_option($blog_id, \Aldine\Admin\BLOG_OPTION));
        $this->assertNotSame('1', get_site_meta($blog_id, BookDataCollector::IN_CATALOG, true));
    }

    public function test_set_catalog_status_skips_main_site()
    {
        $this->assertFalse(Catalog::setCatalogStatus(get_main_site_id(), true));
    }

    public function test_handle_bulk_actions_counts_updated_and_skipped_books()
    {
        $public_id = $this->factory()->blog->create();
        update_blog_option($public_id, 'blog_public', 1);

        $private_id = $this->factory()->blog->create();
        update_blog_option($private_id, 'blog_public', 0);

        $redirect = Catalog::handleBulkActions(
            network_admin_url('sites.php'),
            Catalog::BULK_ADD,
            [$public_id, $private_id]
        );

        $this->assertStringContainsString('pb_aldine_catalog_action=added', $redirect);
        $this->assertStringContainsString('pb_aldine_catalog_updated=1', $redirect);
        $this->assertStringContainsString('pb_aldine_catalog_skipped=1', $redirect);
        $this->assertSame(1, (int) get_blog_option($public_id, \Aldine\Admin\BLOG_OPTION));
        $this->assertFalse(get_blog_option($private_id, \Aldine\Admin\BLOG_OPTION));
    }

    public function test_handle_bulk_actions_removes_books()
    {
        $blog_id = $this->factory()->blog->create();
        update_blog_option($blog_id, 'blog_public', 1);
        Catalog::setCatalogStatus($blog_id, true);

        $redirect = Catalog::handleBulkActions(
            network_admin_url('sites.php'),
            Catalog::BULK_REMOVE,
            [$blog_id]
        );

        $this->assertStringContainsString('pb_aldine_catalog_action=removed', $redirect);
        $this->assertFalse(get_blog_option($blog_id, \Aldine\Admin\BLOG_OPTION));
        $this->assertSame('0', get_site_meta($blog_id, BookDataCollector::IN_CATALOG, true));
    }

    public function test_handle_bulk_actions_ignores_other_actions()
    {
        $redirect = network_admin_url('sites.php');

        $this->assertSame(
            $redirect,
            Catalog::handleBulkActions($redirect, 'delete', [1])
        );
    }
}
