<?php
/**
 * MCP Collections
 *
 * @package           MCPCollections
 * @author            Suraj Singh
 * @copyright         2026 Suraj Singh
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       MCP Collections
 * Plugin URI:        https://example.com/mcp-collections
 * Description:       A collection of MCP (Model Context Protocol) integrations for WordPress.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Suraj Singh
 * Author URI:        https://example.com
 * Text Domain:       mcp-collections
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        false
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants.
define( 'MCP_COLLECTIONS_VERSION', '1.0.0' );
define( 'MCP_COLLECTIONS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MCP_COLLECTIONS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin activation hook.
 */
function mcp_collections_activate() {
	// Set default options.
	add_option( 'mcp_collections_version', MCP_COLLECTIONS_VERSION );
	// Flush rewrite rules.
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mcp_collections_activate' );

/**
 * Plugin deactivation hook.
 */
function mcp_collections_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'mcp_collections_deactivate' );

/**
 * Initialize the plugin.
 */
function mcp_collections_init() {
	load_plugin_textdomain( 'mcp-collections', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'mcp_collections_init' );
