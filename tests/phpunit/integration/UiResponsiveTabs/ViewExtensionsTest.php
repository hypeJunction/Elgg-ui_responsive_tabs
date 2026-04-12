<?php

namespace UiResponsiveTabs;

use Elgg\IntegrationTestCase;

/**
 * Verifies that the ui_responsive_tabs plugin properly registers its view
 * extensions and that the extending views exist and render.
 *
 * The plugin is purely cosmetic: it extends core Elgg views with a responsive
 * tabs stylesheet and a small JS enhancement. There are no entities, actions,
 * hooks or routes — so all testable behaviour lives in the Elgg view system.
 */
class ViewExtensionsTest extends IntegrationTestCase {

    public function up() {}

    public function down() {}

    public function getPluginID(): string {
        return 'ui_responsive_tabs';
    }

    public function testPluginIsActive(): void {
        $plugin = elgg_get_plugin_from_id('ui_responsive_tabs');
        $this->assertNotNull($plugin, 'ui_responsive_tabs plugin should be installed');
        $this->assertTrue($plugin->isActive(), 'ui_responsive_tabs plugin should be active');
    }

    public function testTabsCssViewExists(): void {
        $this->assertTrue(
            elgg_view_exists('elements/navigation/tabs.css'),
            'The tabs.css view provided by the plugin should exist'
        );
    }

    public function testTabsJsViewExists(): void {
        $this->assertTrue(
            elgg_view_exists('elements/navigation/tabs.js'),
            'The tabs.js view provided by the plugin should exist'
        );
    }

    public function testTabsCssRendersNonEmpty(): void {
        $output = elgg_view('elements/navigation/tabs.css');
        $this->assertIsString($output);
        $this->assertNotEmpty(trim($output), 'tabs.css should produce non-empty CSS');
        $this->assertStringContainsString(
            '.elgg-tabs',
            $output,
            'tabs.css should contain .elgg-tabs selectors'
        );
    }

    public function testTabsJsRendersNonEmpty(): void {
        $output = elgg_view('elements/navigation/tabs.js');
        $this->assertIsString($output);
        $this->assertNotEmpty(trim($output), 'tabs.js should produce non-empty JS');
        $this->assertStringContainsString(
            'elgg-tabs',
            $output,
            'tabs.js should reference the .elgg-tabs selector'
        );
    }

    public function testTabsCssExtendsComponentsCss(): void {
        // The plugin registers tabs.css as an extension of elements/components.css
        // via elgg-plugin.php. Rendering components.css should therefore contain
        // the tabs.css payload.
        $components = elgg_view('elements/components.css');
        $this->assertIsString($components);
        $this->assertStringContainsString(
            '.elgg-tabs',
            $components,
            'elements/components.css should include tabs.css content via view extension'
        );
    }

    public function testTabsJsExtendsElggJs(): void {
        // tabs.js is registered as a view extension of elgg.js.
        $elggJs = elgg_view('elgg.js');
        $this->assertIsString($elggJs);
        $this->assertStringContainsString(
            'elgg-tabs',
            $elggJs,
            'elgg.js should include tabs.js content via view extension'
        );
    }

    public function testCoreTabsMenuViewRendersWithPluginActive(): void {
        // Regression guard: the plugin should not break core menu rendering.
        $output = elgg_view_menu('filter', [
            'items' => [
                \ElggMenuItem::factory([
                    'name' => 'all',
                    'text' => 'All',
                    'href' => '#all',
                    'selected' => true,
                ]),
                \ElggMenuItem::factory([
                    'name' => 'mine',
                    'text' => 'Mine',
                    'href' => '#mine',
                ]),
            ],
        ]);
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
        $this->assertStringContainsString('elgg-menu-filter', $output);
    }
}
