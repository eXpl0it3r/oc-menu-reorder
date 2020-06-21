# Menu Reorder

![Menu Reorder](https://i.imgur.com/3P0UuPI.png)

*Menu Reorder* is a very simple [October CMS](https://octobercms.com) plugin to reorder the backen main menu.

By default the backend main menu items are order by the values defined by each plugin in their `Plugin.php`. Menu Reorder allows you to change the order as you see fit.

![Menu Reorder Backend View](https://i.imgur.com/Z04EYpg.png)

![Order being changed](https://i.imgur.com/VZwRp4Y.png)

## Installation

### Marketplace

1. Navigate to 'Settings' > 'Updates & Plugin' in the backend of your October CMS installation
2. Click on '+ Install plugins'
3. Search for 'Menu Reorder'
4. Click on the search result for the plugin

### Artisan CLI

1. Open a terminal and navigate to the October CMS directory
2. Run `php artisan plugin:install Lukas.MenuReorder`

### Manual

1. Download the zip-archive
2. Unpack it into the plugin directory
3. When you log into the backend the next time, the migrations should be applied

## Usage

The plugin registers a new settings navigation item under 'Settings' > 'System' > 'Menu Reorder'.

The reorder list provides you the possibility to change the backend main menu's order.

A change will only become visible once your refresh the page or navigate to a different backend page.

To restore the original order, simply remove the plugin.

## License

This plugin is licensed under the MIT license, see the LICENSE file.

## Credit

- Thanks to [Luke Towers](https://luketowers.ca/) for all the help
- Plugin icon by [Gilad Sotil](https://thenounproject.com/gilad.sotil4231c9c47bce4f03/)