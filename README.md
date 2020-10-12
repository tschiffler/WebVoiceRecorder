# WebVoiceRecorder
This project contains a simple Script that is used to record voice files by users. The Idea of the project is based on a Speech to Text Benachmark where we needed a solution to record a huge amount of voice files by different users. So I decided to create simple web gui where we are able to register users, advice those users to speak given content and save the recorded voice files to the storage.

All functions in a short overview:

- *Adminarea*
    - register as much users as you want to
    - upload content that user has to speak by a simple textfile upload
    - assign tasks to speak to users
- *Userarea*    
    - Users that has been created can sign in
    - User has to accept data privacy before recording is enabled
    - System shows the user the text that has to be spoken
    - User clicks on "Start"-Button to start recording
    - After click on "Stop" recording is stoped, file is tranfered to server
    - After the file is transfered to server, the User is asked to speak the next utterance  

## used technologies
- Language: PHP + JavaScript
- Database: mysql
- Script to record: [recorder.js](https://github.com/mattdiamond/Recorderjs)

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