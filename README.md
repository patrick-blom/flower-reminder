# Flower Reminder
Flower Reminder is the simple way to surprise your partner with some flowers by creating random entries in your 
Google calendar. For example, if you want to surprise you partner with flowers two times within three months for the 
complete year, you can use Flower Reminder to create these events in you Google calendar.

## Requirements
Things you need to use Flower Reminder.
- A Google developer account
- A Google calendar (I used a dedicated one)
- Some machine which runs PHP, git, composer, etc. to run the application

## Installation
### Download Flower Reminder and install it
1. Download the latest version of Flower Reminder
2. Run `composer install -o --no-dev`
3. Run the application with: `php bin/flower-reminder`

### Prepare the Google developer account 
1. Goto `https://console.developers.google.com` and login with your credentials 
2. Create a new project
3. Activate the Google Calendar API
4. Create a new service account
5. Enable key generation
6. Enable G Suite Domain-wide Delegation
7. Save the new key-file.json to `flower-reminder/config/`

### Prepare Google Calendar
1. Goto `https://calendar.google.com/` and login with your credentials 
2. Goto to the Settings Menu and create a new calendar (I called mine Flower Reminder)
3. Share the new calendar with the generated service account id email address and assign the privileges to edit events  

### Prepare the Flower Reminder by editing the parameter.xml
1. `service_account_file` : The name of the key-file.json
2. `calendar_event_msg` : The event name which is displayed in the calendar
3. `calendar_event_msg_description` : The event description
4. `calendar_event_starttime` : The start time of the event hh:mm:ss
5. `calendar_event_endtime` : The end time of the event hh:mm:ss
6. `calendar_event_reminder_mail` : The reminder e-mail address
7. `calendar_event_reminder_in_minutes` : The time the event will be announced

## Usage
### The list command
Use the list command to get the calendar id of the prepared Google Calendar

```
 php bin/flower-reminder reminder:calendar:list
 ----------------- ------------------------------------------------------ 
  Calendar          id                                                    
 ----------------- ------------------------------------------------------ 
  Flower Reminder   averylongidgenratedbygoogle@group.calendar.google.com  
 ----------------- ------------------------------------------------------
```

### The dummy command
Use the dummy command to verify the function of the flower reminder and the communication with Google.
It will generate a calendar event on November 3rd 10am-10:25am for the current year
```
 php bin/flower-reminder reminder:calendar:create:dummy averylongidgenratedbygoogle@group.calendar.google.com
 
 [OK] Event with id 94hsajdfjksdfkfggnvk created     
```
### The random command
Use the random command to create random events in your Google calendar based on the default settings which are: Two 
reminder in three months, four times in row ( aka. one year).

You can customize several settings like start date, intervals, etc. by using the following options. 
```
Options:
      --startdate[=STARTDATE]                                        The start date for the random event generation (default: now) [default: "2016-10-16 22:34:40"]
      --interval-in-months[=INTERVAL-IN-MONTHS]                      The count of months for one interval (defalut: 3) [default: 3]
      --remindings-per-interval[=REMINDINGS-PER-INTERVALL]           The count of reminder per interval (default: 2) [default: 2]
      --intervals[=INTERVALS]                                        The loop of intervals (default: 4) [default: 4]
      --multiple-reminders-per-month[=MULTIPLE-REMINDERS-PER-MONTH]  Allow multiple reminder in a single month (default: 0) [default: 0]
```

```
 php bin/flower-reminder reminder:calendar:create:random averylongidgenratedbygoogle@group.calendar.google.com
 
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
## Testing
1. Run `composer install`
2. Run `php vendor/bin/phpunit tests/`
