## Mars API Website 
The web side of Interstellar's Mars Rover Photo API. This is simply responsible for letting users query the database, for the actual scraper that feeds it check it out [here](https://github.com/InterstellarBot/Mars-API-Scraper).

## Running
This website's built off the Laravel framework. Simply clone the repo and run this for a quick dev environment;
```
npm install
npm run dev
php artisan serve
```

## Using 
I've yet to write proper documentation for the API, so treat this as a tldr.

The following endpoints can be used;
- `/api/rovers/` Gives you a list of all the rovers along with their cameras.
- `/api/rovers/{rover}` Gives you the details of a single rover, using it's ID to identify it.
- `/api/images/{rover}` This is the main one, giving you all the images stored on the rover. You can filter it with the following get params;
    - `per_page` to alter the number of images per page. Between 1-50.
    - `sol` to filter to a specific martian sol.
    - `camera` to filter to a specific rover camera. Use the camera's instrument name.

If your usage of an API like this is to store a full copy of the mars photos, please use the [scraper](https://github.com/InterstellarBot/Mars-API-Scraper) instead to get it from the official source.

All endpoints are rate-limited to the same bucket, 30 reqs/minute. Make sure your code detects and respects any 429's given.
