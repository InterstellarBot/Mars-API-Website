## Mars API Website 
The web side of Interstellar's Mars Rover Photo API. This is simply responsible for letting users query the database, for the actual scraper that feeds it check it out [here](https://github.com/InterstellarBot/Mars-API-Scraper).

## Using the API
All API endpoints start with `https://mars.interstellarbot.xyz/` (e.g. `https://mars.interstellarbot.xyz/api/rovers`). No authentication is needed, and your rate-limited to 30 requests per minute.

> [!IMPORTANT]
> If your usage of an API like this is to store a full copy of the mars photos, please use the [scraper](https://github.com/InterstellarBot/Mars-API-Scraper) instead to get it from the official source.

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
