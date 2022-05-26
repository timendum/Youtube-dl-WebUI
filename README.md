# Youtube-dl WebUI

![Main](https://github.com/timendum/Youtube-dl-WebUI/raw/master/img/main.png)
![List](https://github.com/timendum/Youtube-dl-WebUI/raw/master/img/list.png)

## Description
Youtube-dl WebUI is a small web interface for youtube-dl/yt-dlp. It allows you to host your own video downloader. 
After the download you can stream your videos from your web browser (or VLC or others)
or save it on your computer directly from the list page.

It supports:

* simultaneous downloads in background
* yt-dlp, youtube-dl (and others)
* logging
* fetch info without download

### You can now extract the audio of a video and download multiple videos at the same time !

## Requirements
- A web server (Apache or nginx) on Unix system.
- PHP >= 7 version should be fine.
- Python >= 2.7 for Youtube-dl.
- [yt-dlp](https://github.com/yt-dlp/yt-dlp) or [Youtube-dl](https://github.com/rg3/youtube-dl).
- ffmpeg (or avconv) is required for audio extraction, from youtube-dl doc :
`-x, --extract-audio convert video files to audio-only files (requires ffmpeg or avconv and ffprobe or avprobe)`

## How to install ?
1. Clone this repo in your web folder (ex: `/var/www`).
1. Copy `config/config.php.TEMPLATE` to  `config/config.php` and edit it as you like ([set binary](#set-binary), [change password](#set-a-password)).
1. Check folders permissions (www-data user must be able to write in the download and log folders).
1. Load index.php to check that everything works.

## Set binary
1. Open `config/config.php`.
1. Set `bin` to the path of yt-dlp or youtube-dl instance (es: `/usr/local/bin/yt-dlp`).

## Set a password
1. Open `config/config.php`.
1. Set `security` to `true`.
1. Find a password, hash it with md5 and replace the value of `password` element.

Example (chosen password is `foo`):

```
echo -n foo | md5sum | sed 's/ .*//'
# Returns the hash acbd18db4cc2f85cedef654fccc4a4d8
```

## Set logging
If you want to check the download process, enable logging with these instructions:

1. Open `config/config.php`.
1. Set `log` to `true`.
1. Check the `logFolder` value.


## Library

Youtube-dl WebUI uses:

- [Bootstrap 5](https://getbootstrap.com/docs/5.2/) (with Popper and jQuery 3)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [yt-dlp](https://github.com/yt-dlp/yt-dlp) or [youtube-dl](https://youtube-dl.org/) (or any compatible fork)
- [FFmpeg](https://ffmpeg.org/) for media manipulation, if present
- [Python](http://python.org/) for JSON formatting, if present


## License

Copyright (c) 2018-2022 Timendum

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
