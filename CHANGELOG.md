## Elgg 7.x Migration (2026-05-09)

- Bumped `elgg/elgg` requirement to `~7.0.0`, `php` to `>=8.3`
- Docker test stack added for Elgg 7.x (docker/elgg7/) with PHP 8.3, MySQL 8.0
- No CSS Crush syntax present — native CSS already in use
- No ElggObject instantiation in plugin (no abstract class changes needed)
- No notification handler references (no renames needed)
- No data migration needed

## Elgg 6.x Migration (2026-05-09)

- Bumped `elgg/elgg` requirement to `~6.1.0`, `php` to `>=8.1`, added `ext-intl`
- Converted `tabs.js` from AMD (`require(['jquery'], ...)`) to ES module (`import $ from 'jquery'`)
- Docker test stack added for Elgg 6.x (docker/elgg6/) with MySQL 8.0, PHPUnit 10.5
- `view_extensions` nested-array format unchanged (correct for 6.x)
- No data migration needed

## Elgg 5.x Migration (2026-04-30)

- Bumped `elgg/elgg` requirement to `^5.0`, `php` to `>=8.2`
- Docker test stack updated to PHP 8.2, MySQL 8.0, Elgg 5.1.x
- No plugin logic changes; CSS/JS views unchanged

<a name="1.0.0"></a>
# 1.0.0 (2016-01-22)


### Features

* **releases:** initial commit ([6ece501](https://github.com/hypeJunction/Elgg-ui_responsive_tabs/commit/6ece501))



