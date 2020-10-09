//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");

//add events to those 2 buttons
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);

function startRecording() {
    var constraints = { audio: true, video:false }

	recordButton.disabled = true;
	stopButton.disabled = false;

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		audioContext = new AudioContext();

		gumStream = stream;
		input = audioContext.createMediaStreamSource(stream);

		/*
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
			// SampleRate = 16000 oder 8000
		*/
		rec = new Recorder(input,{numChannels:1, sampleRate:16000})

		//start the recording process
		rec.record()
	}).catch(function(err) {
    	recordButton.disabled = false;
    	stopButton.disabled = true;
	});
}

function stopRecording() {
	//disable the stop button, enable the record too allow for new recordings
	stopButton.disabled = true;
	recordButton.disabled = false;

	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);
}

function createDownloadLink(blob) {

	//name of .wav file to use during upload and download (without extendion)
	var filename = new Date().toISOString();

	// Upload automatic
	var xhr=new XMLHttpRequest();
    xhr.onload=function(e) {
        if(this.readyState === 4) {
            console.log("Server returned: ",e.target.responseText);
        }
        if (xhr.readyState == XMLHttpRequest.DONE) {
            console.log("Upload done");
            location.reload();
        }
    };
    var fd=new FormData();
    fd.append("audio_data",blob, filename);
    xhr.open("POST","upload.php?userId=" + document.getElementById("userId").innerHTML + "&phraseId=" + document.getElementById("phraseId").innerHTML,true);
    xhr.send(fd);
}