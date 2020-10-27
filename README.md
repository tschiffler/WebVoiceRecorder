# WebVoiceRecorder
This project contains a simple Script that is used to record voice files by users. The Idea of the project is based on a Speech to Text Benchmark where we needed a solution to record a huge amount of voice files by different users. So I decided to create simple web gui where we are able to register users, advice those users to speak given content and save the recorded voice files to the storage. After all recordings are done the spoken content can be exported to a CSV-File. This file can be used to create a stt benchmark, calculate the word error rate (wer) or to train and validate a new model.

All functions in a short overview:

- *Adminarea*
    - register as much users as you want to
    - upload content that user has to speak by a simple textfile upload
    - assign tasks to speak to users
    - export spoken content to csv-file with following columns
        - filename
        - id of speaking user
        - language
        - spoken text
- *Userarea*    
    - Users that has been created can sign in
    - User has to accept data privacy before recording is enabled
    - System shows the user the text that has to be spoken
    - after Click on "Start"-Button, recording is enabled
        - use "Stop - File is OK" to save File and go to next
        - use "Stop - File is Broken" to record File again
    - After the file is transfered to server, the User is asked to speak the next utterance  

## Usage

### Login
Login as user that has been definied by adminarea (or directly in database)

![Login Screen](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/screen_login.png?raw=true "Login Screen")

### Admin-Area

#### User-Management
List of existing Users, new Users can be created by click on specified button. To edit a user just click on the requested row

![List of existing Users](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/usermanagement_list.png?raw=true "List of existing Users")

Screen to create or edit a User. Only users with role "Speaker" are able to speak content.

![Create new User](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/usermanagement_create.png?raw=true "Create new User")

#### Content-Management
Upload the CSV-File (example is located in Documentation/02 Dataset) and assign the content that should be spoken to the users.

![manage content that users should speak](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/contentmanagement.png?raw=true "manage content that users should speak")

### User-Area
After every login, every user (role 'Speaker') must approve the data privacy check. All approvals are stored in the database

![data privacy approval](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/user_dataprivacy.png?raw=true "data privacy approval")

The main screen to start a recording. The text that should be spoken is written on the screen. Just click 'Start' button to start the record.

![start recording](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/user_speak_start.png?raw=true "start recording")

While the recording the user can choose if the file was OK or if the user made an mistake to revoke the recording.
 
![stop recording](https://raw.githubusercontent.com/tschiffler/WebVoiceRecorder/main/Documentation/00%20image/user_speak_stop.png?raw=true "stop recording")

**Location of Voice-Files:** All files that are recorded by the users are stored in the /upload directory. Just connect by FTP to your server and download the generated voice files.

## used technologies
- Language: PHP + JavaScript
- Database: mysql
- Script to record: [recorder.js](https://github.com/mattdiamond/Recorderjs)

## server requirements
- Apache Webserver
    - **Important**: The script _must be accessed by https_, otherwise the recorder will not work
- PHP interpreter (current version)
- MySql Database 

## setup
- download or clone the script
- open "config.inc.php" and configure
- initialize database structure with scripts stored in 'Documentation\01 Database-Scripts'
- open browser and navigate to folder where the script is located
- login with adminuser (data located at 2_basedata.sql)
- import the first dataset
  - example located in 'Documentation\02 Dataset' 
- logout as admin and login as user
- klick on Start, start speaking, Stop to end
- voicefile should be recorded and stored in upload-folder

## MIT License

Copyright (c) 2020 Thomas Schiffler

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
