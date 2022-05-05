# TYPO3 Social Data

display social feeds on your website 

## Features
* Create walls consisting of one or multiple feed data
* Supported connectors
  * [facebook](https://github.com/dachcom-digital/typo3-social-data-facebook-connector)
  * [youtube](https://github.com/dachcom-digital/typo3-social-data-youtube-connector)

## Installation

```json
"require" : {
    "dachcom-digital/typo3-social-data" : "~1.0.0",
}
```

## Configuration
In the extension the target folder for storing post assets can be configured.
Make sure that the value holds a valid **combined FAL identifier** (`<storage-uid>:<folder-path>`)

## Setup
In the backend, prepare sysfolders for storing feeds and the posts.

### Create a feed
Create a new record of type "Feed" which is found under the "Social Data" section.
Select a folder as post storage and choose if you want to store assets of this feed's posts in the local filesystem.
For configuring the feed's connector refer to the readme of the corresponding social data connector package.

### Create a wall
To display posts of one or more feeds on your page, create a new record of type "Wall" which is found under the "Social Data" section.
Select the feeds you want their posts to be included in the output.

### Fetch posts
The extension provides a console command `social-data:fetch:posts`, which can be used from cli (for testing).
> To keep the posts in sync, create a scheduled task of type "Execute console commands", and select the above command.

### Display the data
Use the Plugin "Social Data" and select the desired wall to output the posts in the frontend.

### Troubleshooting
Log messages are logged into `var/log/typo3_socialdata_<hash>.log`.
The level of respected messages depends on the application context.
Switch the application context to Development to have more detailed logs.

## Create custom connector
* create implementations of
  * `ConnectorDefinitionInterface` (puts connector and feed configuration together)
  * `ConnectorFeedConfigurationInterface` (model for the connector's feed configuration)
    * create the flex form file with the configuration fields
    * create the connector status form element class (use `AbstractConnectorStatusElement` as a base)
  * `ConnectorInterface` (business logic to fetch the data)
    * make sure the items returned by `fetchItems` are correctly prepared
      ```php
      [
          'id'         => // string, must be unique for posts in this feed
          'title'      => // string
          'content'    => // string
          'datetime'   => // DateTime|null
          'url'        => // string, absolute url to the post, 
          'posterUrl'  => // string, absolute url to the poster image
          'mediaUrl'   => // string, absolute url to media (video, image or link)
      ]
      ```
* register the connector implementation:
  ```yaml
  YourVendor\YourPackage\Connector\YourConnectorDefinition:
        tags:
            - name: social_data.connector_definition
              identifier: your-identifier
              connector: YourVendor\YourPackage\Connector\YourConnector 
  ```
* 

## Copyright and License
Copyright: [DACHCOM.DIGITAL](https://dachcom.com)
For licensing details please visit [LICENSE.md](LICENSE.md)
