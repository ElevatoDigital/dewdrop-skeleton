# dewdrop-skeleton
The project template for new Dewdrop projects.  Can be used via composer create-project.

This is in the early stages but should work for WordPress projects.  Follow these steps to create a new plugin:

1. Navigate to the plugins folder of your WordPress install. (wp-content/plugins)
1. Install composer globally if you haven't already.  (See <https://getcomposer.org/doc/00-intro.md#globally>)
1. Run `composer create-project deltasystems/dewdrop-skeleton my-new-plugin dev-master`
1. Activate your plugin.  You should see an example admin component named Dewdrop in your WordPress admin menu.
1. Install [WP\_Session](https://wordpress.org/support/plugin/wp-session-manager) if you intend to use any session functionality.

