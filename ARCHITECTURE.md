# ui_responsive_tabs — Architecture (Elgg 7.x)

## Summary

ui_responsive_tabs provides responsive tab navigation for Elgg by injecting
CSS and JS view extensions into Elgg's asset pipeline. No PHP logic.

## View Extensions

| Extends | With |
|---------|------|
| `elements/components.css` | `elements/navigation/tabs.css` |
| `elgg.js` | `elements/navigation/tabs.js` |

## JS (ESM, Elgg 6.x)

`elements/navigation/tabs.js` uses an ES module (`import $ from 'jquery'`).
RequireJS/AMD was removed in Elgg 6.x. On click of a selected tab/filter item,
it toggles `elgg-state-active` on the parent `<ul>`, which collapses/expands
the menu on narrow viewports.

## Dependencies

None — leaf plugin.

## Migration Notes (3.x → 4.x)

- `manifest.xml` removed; `composer.json` is now the sole metadata source.
- `elgg-plugin.php` received the `'plugin'` key.
- `elgg/elgg ^4.0` and `php >=7.4` added; `composer/installers` bumped to `^2.0`.

## Migration Notes (4.x → 5.x)

- `elgg/elgg ^5.0` and `php >=8.2` added in `composer.json`.
- Docker test stack updated to PHP 8.2 / MySQL 8.0 / Elgg 5.1.x.
- No plugin PHP logic changes required; CSS/JS views are unchanged.
- `view_extensions` nested-array format retained (works correctly in Elgg 5.x).

## Migration Notes (5.x → 6.x)

- `elgg/elgg ~6.1.0`, `php >=8.1`, `ext-intl` added in `composer.json`.
- `tabs.js` converted from AMD (`require(['jquery'],...`) to ESM (`import $ from 'jquery'`).
- Docker test stack added for Elgg 6.x (docker/elgg6/) with PHPUnit 10.5.
- `view_extensions` nested-array format unchanged (correct for 6.x).
- No data migration needed.

## Migration Notes (6.x → 7.x)

- `elgg/elgg ~7.0.0`, `php >=8.3` updated in `composer.json`.
- Docker test stack added for Elgg 7.x (docker/elgg7/) with PHP 8.3.
- CSS uses native CSS already — no CSS Crush variables to replace.
- No ElggObject direct instantiation (no abstract class changes needed).
- No notification handler classes referenced (no renames needed).
- No data migration needed.

## Seeding

No seeder required. This plugin owns no entity types, subtypes, or persistent relationship schemas — it is a pure UI/utility/admin plugin with no persisted entity surface of its own.
