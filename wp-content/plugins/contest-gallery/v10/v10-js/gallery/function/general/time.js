cgJsClass.gallery.function.general.time = {
    photoContestStartTimeCheck: function(gid,ActualTimeSecondsFromPhp,ContestStartTimeFromPhp,cg_ContestStart){

        if(ActualTimeSecondsFromPhp<ContestStartTimeFromPhp && cg_ContestStart == 1){

            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.ThePhotoContestHasNotStartedYet);
            return false;
        }else{
            return true;
        }

    },
    photoContestEndTimeCheck: function(gid,ActualTimeSecondsFromPhp,ContestStartTimeFromPhp,cg_ContestEnd){

        if((ContestStartTimeFromPhp >= ActualTimeSecondsFromPhp && cg_ContestEnd == 1) || cg_ContestEnd==2){
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.ThePhotoContestIsOver);
            return false;
        }else{
            return true;
        }

    },
    correctTimezoneOffset: function (gid,ActualTimeSeconds,ContestEndTimeFromPhp) {

        if(typeof ContestEndTimeFromPhp!='undefined'){
            var cg_ContestEndTime = parseInt(ContestEndTimeFromPhp);
        }else{
            var cg_ContestEndTime = parseInt(cgJsData[gid].options.general.ContestEndTime);
        }

        if(cg_ContestEndTime!='' && cg_ContestEndTime>0){
            var date = new Date();
            var timezoneOffsetBrowser = date.getTimezoneOffset();// offset in MINUTES
            var timezoneServer = cgJsClass.gallery.vars.timezoneOffset;// offset in MINUTES
            var correctTimezone = 0;// offset in MINUTES
            var correctSeconds = 0;

            if (timezoneOffsetBrowser == timezoneServer) {
                correctTimezone = 0;
            }

            if (timezoneOffsetBrowser < timezoneServer) {
                correctTimezone = (timezoneServer - timezoneOffsetBrowser)*-1;
            }

            if (timezoneOffsetBrowser > timezoneServer) {
                correctTimezone = timezoneOffsetBrowser-timezoneServer;
            }

            if(correctTimezone!=0){
                correctSeconds = correctTimezone*60; // 1 min = 60 sekunden
            }

            cg_ContestEndTime = cg_ContestEndTime + correctSeconds;
            return cg_ContestEndTime;
        }else{
            cg_ContestEndTime = 0;
            return cg_ContestEndTime;
        }
    },
    getTime: function (cg_ContestEndTime, ActualTimeSeconds) {

        // Create a new JavaScript Date object based on the timestamp
// multiplied by 1000 so that the argument is in milliseconds, not seconds.
        var date = new Date(ActualTimeSeconds*1000);
// Hours part from the timestamp
        var hours = date.getHours();
// Minutes part from the timestamp
        var minutes = "0" + date.getMinutes();
// Seconds part from the timestamp
        var seconds = "0" + date.getSeconds();

// Will display time in 10:30:23 format
        ActualTimeSeconds = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

        // Create a new JavaScript Date object based on the timestamp
// multiplied by 1000 so that the argument is in milliseconds, not seconds.
        var date = new Date(cg_ContestEndTime*1000);
// Hours part from the timestamp
        var hours = date.getHours();
// Minutes part from the timestamp
        var minutes = "0" + date.getMinutes();
// Seconds part from the timestamp
        var seconds = "0" + date.getSeconds();

// Will display time in 10:30:23 format
        cg_ContestEndTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

        alert(ActualTimeSeconds);
        alert(cg_ContestEndTime);

    }
};