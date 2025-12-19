# Mars Image API Website 
> [!IMPORTANT]
> If your here for the source-code, this is only the website responsible for letting users query the database. For the actual scraper that feeds the database with the images, [find it here](https://github.com/InterstellarBot/Mars-API-Scraper).

NASA's rovers on Mars capture hundreds of images every day with tens of cameras, but NASA doesn't have a portal to make these accessible from a single place. This API intends to prove that place, letting developers and researchers query and access these photos from a single database.  
This project is maintained under the umbrella of the Interstellar Discord Bot. No, this doesn't mean I plan on commercialising it.

This work is heavily based off [Chris Cerami's Mars Photo API](https://github.com/corincerami/mars-photo-api), which has now been archived. I never stood up to possibly maintain it due to the fact I'm unfamiliar with Ruby and personally use lower level languages, expecting another maintainer to hopefully come to the rescue. Since they haven't, I've rewritten his code into a Rust scraper and a PHP website to continue the API.

If you need help or just want someone to talk to, come join [Interstellar's Discord Server](https://interstellarbot.xyz/discord)!

## After all the images?
If your after a full copy of every image and not just occasional queries of images, please consider hosting your own version of [the scraper](https://github.com/InterstellarBot/Mars-API-Scraper) instead. This way, your not hammering my servers and you don't have to worry about rate-limits by querying the database directly. A win-win. 

The scraper is a single executable, as long as you have access to a server of some-kind (preferably Linux) you can host it quite easily as a background service.

## Using the API
All API endpoints start with `https://mars.interstellarbot.xyz/` (e.g. `https://mars.interstellarbot.xyz/api/rovers`).

### Rate-Limits & Authentication
There is no authentication nor API key requirements, with a base rate-limit of 30 requests per second applied to each IP address. This may change if the API becomes popular enough to hammer the hell out of my servers.

If you require more lenient rate-limits, contact me at `livaco@livaco.dev` or `livaco` on Discord and we can discuss potentially setting up a API Key for you to use instead depending on your use-case. I would prefer however you peek at the above option of hosting the scraper directly. 

### Data Structures
All of the types of data structures that can be present. Any property that ends with a questionmark is nullable.

**Rover**

| Property            | Description                                               |
| ------------------- | --------------------------------------------------------- |
| id                  | The identifier of the rover.                              |
| name?               | The human friendly name of the rover.                     |
| last_sol_processed? | The last sol that was processed for the rover.            |
| cameras?            | An array of the RoverCamera's associated with this rover. |


**RoverCamera**

| Property        | Description                                                 |
| --------------- | ----------------------------------------------------------- |
| camera_id       | The identifier of the camera.                               |
| rover_id        | The identifier of the rover the camera is associated with.  |
| instrument_name | The "scientific" name of the camera, as NASA identifies it. |
| name?           | The human-friendly name of the rover camera.                |

**RoverImage**

| Property  | Description                                                 |
| --------- | ----------------------------------------------------------- |
| nasa_id   | The identifier NASA gives to the image.                     |
| rover_id  | The identifier of the rover the image is associated with.   |
| image_url | The URL to the raw image.                                   |
| caption?  | The caption/description that NASA describes the image with. |
| timestamp | The unix timestamp of the time the picture was taken.       |
| sol       | The martian sol the image was taken on.                     |
| title     | The title NASA gives the image.                             |
| credit?   | The credits that NASA attributes the image to.              |
| camera    | The RoverCamera that took the image.                        |


### `/api/rovers`
This endpoint gives you a list of all the available rovers, along with a list of their cameras.

`/api/rovers`
```json
[
  {
    "id": "curiosity",
    "name": "Curiosity",
    "last_sol_processed": 4746,
    "cameras": [
      {
        "camera_id": "curiosity-chemcam",
        "rover_id": "curiosity",
        "instrument_name": "CHEMCAM",
        "name": "Chemistry and Camera Complex"
      },
      ...
    ]
  },
{
    "id": "perseverance",
    "name": "Perseverance",
    "last_sol_processed": 1711,
    "cameras": [
      {
        "camera_id": "perseverance-edl_ddcam",
        "rover_id": "perseverance",
        "instrument_name": "EDL_DDCAM",
        "name": "Descent Stage Down-Look Camera"
      },
      ...
    ]
  }
]
```

### `/api/rovers/{rover_id}`
Provides the details of a *specific* rover, using their ID.

`/api/rovers/perseverance`
```json
{
  "id": "perseverance",
  "name": "Perseverance",
  "last_sol_processed": 1711,
  "cameras": [
    {
      "camera_id": "perseverance-edl_ddcam",
      "rover_id": "perseverance",
      "instrument_name": "EDL_DDCAM",
      "name": "Descent Stage Down-Look Camera"
    },
    ...
  ]
}
```

### `/api/images/{rover_id}`
This is the main one your after. This gives you all the images from the rover that you specify, pagnated to prevent the API having to send too much information.

`/api/images/perseverance?sol=52`
```json
{
  "current_page": 1,
  "data": [
    {
      "nasa_id": "FLF_0052_0671563995_536ECM_N0032046FHAZ02003_01_195J",
      "rover_id": "perseverance",
      "image_url": "https://mars.nasa.gov/mars2020-raw-images/pub/ods/surface/sol/00052/ids/edr/browse/fcam/FLF_0052_0671563995_536ECM_N0032046FHAZ02003_01_195J01_1200.jpg",
      "caption": "NASA's Mars Perseverance rover acquired this image of the area in front of it using its onboard Front Left Hazard Avoidance Camera A. \n\nThis image was acquired on April 13, 2021 (Sol 52) at the local mean solar time of 14:28:44.",
      "timestamp": 1618292127,
      "sol": 52,
      "title": "Mars Perseverance Sol 52: Front Left Hazard Avoidance Camera (Hazcam)",
      "credit": "NASA/JPL-Caltech",
      "camera": {
        "camera_id": "perseverance-front_hazcam_left_a",
        "rover_id": "perseverance",
        "instrument_name": "FRONT_HAZCAM_LEFT_A",
        "name": "Front Hazard Camera - Left"
      }
    },
    ...
  ],
  "first_page_url": "https://mars.interstellarbot.xyz/api/images/perseverance?page=1",
  "from": 1,
  "last_page": 33328,
  "last_page_url": "https://mars.interstellarbot.xyz/api/images/perseverance?page=33328",
  "links": [
    ...
  ],
  "next_page_url": "https://mars.interstellarbot.xyz/api/images/perseverance?page=2",
  "path": "https://mars.interstellarbot.xyz/api/images/perseverance",
  "per_page": 15,
  "prev_page_url": null,
  "to": 15,
  "total": 499906
}
```

The following GET parameters are available:
- `per_page` to alter the number of images per page. Between 1-50.
- `sol` to filter to a specific martian sol.
- `camera` to filter to a specific rover camera. Use the camera's instrument name.


## Source Code Locations 
This project is split into two repositories; the website (this repo!) and the scraper that feeds the database of images itself. Both parts are fully open source, licenced under MIT;
- [The Scraper](https://github.com/InterstellarBot/Mars-API-Scraper), responsible for gathering the photos, written in Rust.
- [The Website](https://github.com/InterstellarBot/Mars-API-Website), where you are currently and responsible for the API and querying the database, written in PHP using the Laravel framework.


## Running Yourself
This website uses the Laravel framework, so make sure you have the [dependencies Laravel needs](https://laravel.com/docs/12.x/deployment).

Then, you can just clone the repo, install all the composer and npm stuff and run the development server;
```
git clone https://github.com/InterstellarBot/Mars-API-Website
cd ./Mars-API-Website
composer install
npm install
npm run build
php artisan serve
```

To remind you in-case you skipped past the above; This website only queries the database, the actual scraper that fills the data in is a seperate program found [here](https://github.com/InterstellarBot/Mars-API-Scraper).
