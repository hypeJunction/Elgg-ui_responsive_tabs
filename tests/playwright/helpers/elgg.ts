import { Page } from '@playwright/test';
import mysql from 'mysql2/promise';

const DB_CONFIG = {
  host: process.env.ELGG_DB_HOST || 'db',
  port: Number(process.env.ELGG_DB_PORT || 3306),
  user: process.env.ELGG_DB_USER || 'elgg',
  password: process.env.ELGG_DB_PASS || 'elgg',
  database: process.env.ELGG_DB_NAME || 'elgg',
};

export async function loginAs(
  page: Page,
  username: string,
  password: string = 'testpass123'
) {
  await page.goto('/login');
  await page.fill('input[name="username"]', username);
  await page.fill('input[name="password"]', password);
  await page.click('button[type="submit"]');
  await page.waitForLoadState('networkidle');
}

export async function queryDb(sql: string, params: any[] = []) {
  const conn = await mysql.createConnection(DB_CONFIG);
  const [rows] = await conn.execute(sql, params);
  await conn.end();
  return rows;
}

/**
 * Returns true if the ui_responsive_tabs plugin is active in the test DB.
 */
export async function isPluginActive(pluginId: string): Promise<boolean> {
  const rows: any = await queryDb(
    `SELECT ps.value
     FROM elgg_private_settings ps
     INNER JOIN elgg_entities e ON e.guid = ps.entity_guid
     WHERE e.type = 'object' AND e.subtype = 'plugin'
       AND ps.name = 'active' AND ps.value = '1'
       AND e.guid IN (
         SELECT entity_guid FROM elgg_metadata
         WHERE name = 'title' AND value = ?
       )`,
    [pluginId]
  );
  return Array.isArray(rows) && rows.length > 0;
}
