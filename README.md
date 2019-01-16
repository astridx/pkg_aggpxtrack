# pkg_gpxtrack / Joomla Custom Field for dispaying a GPX-Track
 
# Quickstart

1. Install this package via Joomla! installer. 
Please activate the plugin via `Extension | Plugins` before you use it. 
If you do not find the plugin entry, you can search it via the search field.

![b1](https://user-images.githubusercontent.com/9974686/51280066-0263b100-19df-11e9-8113-647e1429ae3d.png)

2. Allow the upload of GPX-Files
Open `Global Configuration` and click in the left side menu `Media`. 
After that add `,GPX,gpx` to the field `Legal Extensions (File Types)` and 
`,text/xml` to the field `Legal MIME Types`.

![b6](https://user-images.githubusercontent.com/9974686/51280072-0394de00-19df-11e9-941b-e07c43ad80f7.png)

3. Open the menu `Content | Articles` and select in the left side menu `fields`. 
After that click `new` in toolbar on the top.

![b2](https://user-images.githubusercontent.com/9974686/51280067-02fc4780-19df-11e9-909b-3533a3bf3af7.png)

4. Now you can create the field
At least you have to fill the title and you have to select the type `aggpxtrack`. 
At the end you have to click the toolbar button `save and close`.

![b3](https://user-images.githubusercontent.com/9974686/51280068-02fc4780-19df-11e9-8cfc-9b864ac974e2.png)

5. Open the menu `Content | Articles` and select in the left sidebar `articles`.
Click on one article for editing this article. 

![b4](https://user-images.githubusercontent.com/9974686/51280069-02fc4780-19df-11e9-996b-418aeae76fbd.png)

6. Open the fields tab and select a GPX-Track 
If you not allready have uploaded a GPX file, 
you can upload a GPX-Track into the media manager of your website.

![b5](https://user-images.githubusercontent.com/9974686/51280071-02fc4780-19df-11e9-9cf5-1bd7f76e8ba6.png)

7. See your GPX-Track in the front end

![b7](https://user-images.githubusercontent.com/9974686/51280074-0394de00-19df-11e9-8ca9-edd81e0d0fd2.png)

# Options

## Download the GPX-Datei
If you want, you can allow to download the GPX file in the frontend. 
Simply set the `download link` option to `yes` in the options of the custom field. 
In the front end you will see a link below the map. 
If you click this link, the GPX file is downloaded.

## Tile Server
You can choose the Tile Server. You can choose 
- Google Maps, 
- Openstreetmaps, 
- Openstreetmaps.BlackandWhite, 
- Thunderforest, 
- OpenTopoMap or Mapbox.  
If you choose Mapbox, Thunderforest or Google Maps you have to insert your own 
access token. You can request this from the respective map provider. 
The license terms can also be viewed at the respective card provider.

## Display options
You can choose which elements of your GPX track to display. 
By default, the three elements 
- Track, 
- Route and 
- Waypoint  
are displayed. You can also specify the color of the line of the track. 
And last but not least, you can specify the icons user-defined. 
Here you can choose from all Font Awesome Icons. 
With custom icons, you can freely set the start icon, end icon and each 
waypoint icon. You can choose the 
- icon image, 
- a background color, 
- a symbol color and 
- a custom class.  
- You can also specify whether the icon image should rotate.

## Additional Information of the GPX File
If your GPX file contains more information, you can display 
this imformation below the map. In Custom Field options, select which 
information to display. You can choose 
- Distance, 
- Name of the track, 
- Start time, 
- Moving time, 
- Total time, 
- Moving pace, 
- Moving speed, 
- Total speed, 
- Elevation (min), 
- Elevation (max), 
- Elevation (gain), 
- Elevation (loss), 
- Average heart rate and 
- Average temperature.  
The entry appears in the frontend below the map. Each entry has a CSS ID and 
can be created in the `custom.css` - or `user.css` - of your template.

## Elevation profile
You can display the elevation profile for the GPX track on the map. 
The option is located at the bottom of the Custom Field options. 
If you activate the elevation profile, you will see additional options.

## More Options
You can also show KML overlays, enable live tracking, and switch to 
front end full-screen mode.

# All parts of this extension

## Plugin: Fields - Aggpxtrack  
You habe to actiate this extension. It is the main part of this extension.

## Component - Aggpxtrack  
The Component is used for showing a view for selecting the GPX-File.

## Plugin: Installer - Aggpxtrack  
This extension is currently not used.


# FAQ
## What is a gpxtrack?
It is a file in the format GPX or [GPS Exchange Format](https://en.wikipedia.org/wiki/GPS_Exchange_Format)

# Support and New Features

This Joomla! Extension is a simple feature. But it is most likely, that your requirements are 
already covered or require very little adaptation.

If you have more complex requirements, need new features or just need some support, 
I am open to doing paid custom work and support around this Joomla! Extension. 

Contact me and we'll sort this out!
