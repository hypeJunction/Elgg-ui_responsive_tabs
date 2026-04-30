# ui_responsive_tabs — Architecture (Elgg 5.x)

## Summary

ui_responsive_tabs provides responsive tab navigation for Elgg by injecting
CSS and JS view extensions into Elgg's asset pipeline. No PHP logic.

## View Extensions

| Extends | With |
|---------|------|
| `elements/components.css` | `elements/navigation/tabs.css` |
| `elgg.js` | `elements/navigation/tabs.js` |

## JS (AMD, Elgg 5.x)

`elements/navigation/tabs.js` uses a `require(['jquery'], ...)` AMD module
(AMD is still supported in Elgg 5.x). On click of a selected tab/filter item,
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
