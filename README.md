# tallytoo-wall (beta)
A monetisation plugin for WordPress based on the [tallytoo](https://tallytoo.com) platform.

__This plugin creates a customisable paywall, a donate-wall or an inline donation request.__


[Tallytoo](https://tallytoo.com) provides an ad-based content-monetisation service that you can integrate freely into your website.

Users earn points on the tallytoo platform, by engaging with interactive ads served by tallytoo, which they can then \'spend\' on your website. Tallytoo will pay you the equivalent amount in cash as the number of points spent on your site.

All you need to do is create a free tallytoo account, integrate this plugin, and you can start monetising your content.

_If you wish another type of WordPress integration that does not require the creation of a paywall, do not hesitate to contact us at [support@tallytoo.com](mailto:support@tallytoo.com)!_

_This plugin is still in beta, which is why it is currently only available via GitHub. Once the beta phase is over, it will be made available in the WordPress plugins directory. To report any problems, please do not hesitate to contact us as [support@tallytoo.com](mailto:support@tallytoo.com)._

## Step by step installation instructions

1. Download the the plugin by clicking the "Latest Release" button
2. Install the plugin into your WordPress site via the menu "Plugins" -> "Add" -> Upload a plugin
3. Activate the plugin by clicking the link "Activate"
4. [Create a publisher account at tallytoo](https://app.tallytoo.com/publisher). You will need to register using an email address or a social media account.
5. Once registered, log in and click "Register a publisher". Please provide all the required information. Someone from tallytoo will get back to you shortly in order to validate your account.
6. Once your account is validated, log in and select your publisher from the list.
7. By default, a publisher account is not activated. This prevents the tallytoo button from appearing on your website. To activate your account, click the green "Activate" button. You can also finely test your integration (see [Testing the button before deployment](https://github.com/tallytoo/tallytoo-wall#testing-the-button-before-deployment))
8. Go to the "Integration" menu.
9. Register your website domain, including the protocol: for example http://acme.com. You can register a number of domains.
10. Create an API Key. Copy this key.
11. Return to your WordPress admin site. On the menu there is a new tallytoo menu. Go to "Registration".
12. Copy the API Key you registered in the tallytoo publisher portal into the "Publisher API key" field. Click "Save Settings".
13. Your setup should be complete. To check, go to the Paywall menu. The blue tallytoo button should appear. 

_If the blue tallytoo button does not appear, open the javascript console to get more information about why!_

## Protecting your content (paywall)

The tallytoo-wall plugin creates a paywall, donate-wall or donate request via short-codes.

To protect some content, wrap that content in the shortcode:
```
[tallytoo-paywall cost=1] ... your content to be protected ... [/tallytoo-paywall]
```

The plugin will replace your content with the paywall you can customise in the "Paywall" submenu of the tallytoo plugin.  You can change the number of points you require for access to this content, but be advised you risk deterring your users for values higher than 2.

## Protecting your content by requesting a donation (donate-wall)

The donate-wall option allows your visitor to bypass the ad-payment. Use this option if you are worried about losing visitors. Be sure to include a well written explanation in the "Donate-wall" customisation screen, that will convince your readers to donate their time for your benefit.

```
[tallytoo-donatewall cost=1] ... your content to be protected ... [/tallytoo-donatewall]
```


## Non-blocking donation 

You also have the option to just insert a donation request within your content. This option will not hide any original content. 

```
[tallytoo-donate cost=1][/tallytoo-donate]
```

## Customize your button

The button is fully customisable, and this can be done in the menu "Appearance". Make your changes, and click the "Save settings" button to see the results.

The only features that are not customisable are:

* The tallytoo logo
* The text that appears in the button (currently, the text automatically shows in English or French, according to the user's browser settings)


## Testing the button before deployment

You can test and customise the tallytoo button without it appearing for your visitors.

First create a private page or post in WordPress. This can be done by changing the "Visibility" property to private. Now this page is available only to you, the administrator of the website.

In the [publisher portal](https://app.tallytoo.com/publisher), click on the top level menu, and make sure the state of your integration is "Inactive". In an inactive state, the tallytoo button will only appear for a logged-in test user. You can create test-users with or without tallytoo points in the "Test Users" menu. 

Log in as one of your test users.

_Note: all points earned or spent as a test user are null, and will not earn you anything. Test users are exclusively for testing integration._

Refresh your private web-page in which you have flagged your content for protection. You can test how the tallytoo button appears, how the overlay opens, and what happens when a point is earned.

Once you are done, you can activate your account again via the top level menu.

## A best effort solution

Tallytoo is actively encouraging advertisers to use our platform. The more publishers we have, the easier it is to attract paying advertisers.

However, there may be times where no ads match your visitor's profile. 

If your visitor __already has some points__, the tallytoo button will appear, allowing your visitor to spend these points on your content, regardless of whether or not these points were spent on your website.

If your visitor __has no points__, the tallytoo paywall will not appear, since having no matching ads, it makes no sense to show the paywall. You can decide how to respond in two ways:

1. Allow free access to the content (default), which will just show the content if absolutely no monetisation options are found.
2. Keep the paywall, if you have an alternative monetisation solution. 

This choice can be made in the menu "Registration" under the "Allow free access" option.

