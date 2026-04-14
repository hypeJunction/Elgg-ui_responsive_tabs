# ui_responsive_tabs — Architecture (Elgg 4.x)

## Summary

ui_responsive_tabs provides responsive tab navigation for Elgg by injecting
CSS and JS view extensions into Elgg's asset pipeline. No PHP logic.

## View Extensions

| Extends | With |
|---------|------|
| `elements/components.css` | `elements/navigation/tabs.css` |
| `elgg.js` | `elements/navigation/tabs.js` |

## Dependencies

None — leaf plugin.

## Migration Notes (3.x → 4.x)

- `manifest.xml` removed; `composer.json` is now the sole metadata source.
- `elgg-plugin.php` received the `'plugin'` key.
- `elgg/elgg ^4.0` and `php >=7.4` added; `composer/installers` bumped to `^2.0`.
