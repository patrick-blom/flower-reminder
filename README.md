#Random Flower Reminder
The simple way to surprise your woman using the symfony console

##Requirements
- a google developer account
- a google calendar

##Installation
###Prepare Google Dev
1. goto `https://console.developers.google.com`
2. create a new project
3. activate the Google Calendar API
4. create a new service account
5. enable key generation
6. enable G Suite Domain-wide Delegation
7. save the new key-file.json to `flower-reminder/config/`

###Prepare Google Calendar
1. create an new calender
2. share the new calender with the generated service account id email adress

###Prepare the Flower Reminder and edit the parameter.xml
1. `service_account_file` : The name of the key-file.json
2. `calendar_event_msg` : The event name which is displayed in the calendar
3. `calendar_event_msg_description` : The event description
4. `calendar_event_starttime` : The start time of the event hh:mm:ss
5. `calendar_event_endtime` : The end time of the event hh:mm:ss
6. `calendar_event_reminder_mail` : The reminder e-mail address
6. `calendar_event_reminder_in_minutes` : The time the event will be announced

##Usage
###The list command
Use the list command to get the calendar id of the prepared Google Calendar
```
 php bin/application reminder:calendar:list
 ----------------- ------------------------------------------------------ 
  Calendar          id                                                    
 ----------------- ------------------------------------------------------ 
  Flower Reminder   averylongidgenratedbygoogle@group.calendar.google.com  
 ----------------- ------------------------------------------------------
```
###The dummy command
Use the dummy command to verify the function of the flower reminder and the communication with google.
It will generate an calendar event on November 3rd 10am-10:25am
```
 php bin/application reminder:calendar:create:dummy averylongidgenratedbygoogle@group.calendar.google.com
 
 [OK] Event with id 94hsajdfjksdfkfggnvk created     
```
###The random command
Use the random command to create the random events in your google calendar
```
 php bin/application reminder:calendar:create:random averylongidgenratedbygoogle@group.calendar.google.com
 
  ! [NOTE] Creating random events                                                                                        
 
  8/8 [============================] 100%
  
  ! [NOTE] Listing events                                                                                                
 
  ---------------------------- --------------- 
   Event Id                     Calendar Date  
  ---------------------------- --------------- 
   3375oij0eurngq9ii01hmvlv5g   2016-10-24     
   peb90kebecdhsrtr6siaafv4f4   2016-12-02     
   t4hvp94r2tu0jhu670c6oeri1o   2017-01-23     
   cca0podk0goi2u6kk3u9hd8l28   2017-03-23     
   pmc92icqg9t12nirrqfdk7ac04   2017-05-22     
   uiavo9ju71c5ui7j5moqcopmn0   2017-06-19     
   vt9te7qle5cafel5glugj1mobg   2017-07-31     
   s7r468qfna1886ue7l3olh3hio   2017-08-06     
  ---------------------------- --------------- 
 
                                                                                                                         
  [OK] Events created                                                                                                    
                                                                                                                         
```

You can use the optional commands to modify the default behavior:

```
Options:
      --startdate[=STARTDATE]                                        The start date for the random event generation (default: now) [default: "2016-10-16 22:34:40"]
      --interval-in-months[=INTERVAL-IN-MONTHS]                      The count of months for one intervall (defalut: 3) [default: 3]
      --remindings-per-intervall[=REMINDINGS-PER-INTERVALL]          The count of remindings per interval (default: 2) [default: 2]
      --intervals[=INTERVALS]                                        The loop of intervals (default: 4) [default: 4]
      --multiple-reminders-per-month[=MULTIPLE-REMINDERS-PER-MONTH]  Allow Multiple remindings in a single month (default: 0) [default: 0]
```
