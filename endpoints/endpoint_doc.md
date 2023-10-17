GET:

    User:
        - get Account from email X                          /index.php/Account/email=X

        - get Event X                                       /index.php/Event/event_id=X
        - get Events by name X                              /index.php/Event/name=X
        -- is there a need to select Events with rating?

        - get Location X                                    /index.php/Location/location_id=X
        - get Locations from country X                      /index.php/Location/country=X
        - get Locations from zip code X                     /index.php/Location/zip=X
        - get Locations from city X                         /index.php/Location/city=X

        - get event instances of Event X                    /index.php/Event_Instance/event_id=X
        - get event instances of Location X                 /index.php/Event_Instance/location_id=X
        - get event instances of Event X on Location Y      /index.php/Event_Instance/event_id=X:location_id=Y
        - get event instances from date X to Y              /index.php/Event_Instance/date_from=X:date_to=Y
        - get event instances on date X, from time Y to Z   /index.php/Event_Instance/date=X:time_from=Y:time_to=Z

        - get Categories                                    /index.php/Category/
        - get Category tree of Category X                   /index.php/Category/name=X

        - get main Comments from Event X                    /index.php/Comment/event_id=X
        - get subComments of Comment X                      /index.php/Comment/comment_id=X
        -- is there a need to select comments by Account?

        - get Entrance_Fee by Event X                       /index.php/Entrance_Fee/event_id=X
        
        - get Registrations by email X                      /index.php/Registration/email=X

    Moderator:
        - get Events by status X                            /index.php/Event/status=X
        - get Locations by status X                         /index.php/Location/status=X
        - get Categories by status X                        /index.php/Category/status=X

    Administrator:
        - get Account from email X                          /index.php/Account/email=X
        -- User can only access his own Account, Administrator can access any Account

POST:

    User:
        - post create Account                               /index.php/Account/create

        - post create Event                                 /index.php/Event/create
        - post create instance for Event X on Location Y    /index.php/Event/create_instance/event_id=X:location_id=Y
        - post propose Event X                              /index.php/Event/propose/event_id=X

        - post propose Location                             /index.php/Location/propose

        - post propose Category                             /index.php/Category/propose

        - post Comment on Event X                           /index.php/Comment/event_id=X
        - post Comment on Comment X                         /index.php/Comment/comment_id=X

        - post Entrance_Fee to Event X                      /index.php/Entrance_Fee/event_id=X

        - post Registration to Entrance_Fee X               /index.php/Registration/fee_id=X

PUT:

    User:
        - put new email to Account X                        /index.php/Account/email=X
        - put new nick to Account X                         /index.php/Account/email=X
        - put new password to Account X                     /index.php/Account/email=X

        - put new Category to Event X                       /index.php/Event/event_id=X

        - put new cost for Event X's Entrance_Fee Y         /index.php/Entrance_Fee/event_id=X:fee_id=Y

    Moderator:
        - put new status to Event X                         /index.php/Event/event_id=X
        - put new status to Location X                      /index.php/Location/location_id=X
        - put new status to Category X                      /index.php/Category/name=X
    
    Administrator:
        - put new status to Account X                       /index.php/Account/email=X

DELETE:

    User:
        - delete Account X                                  /index.php/Account/email=X
        - delete photo on Account X                         /index.php/Account/email=X:photo

        - delete Event X                                    /index.php/Event/event_id=X
        - delete event instance of Event X on Location Y    /index.php/Event/event_instance/event_id=X:location_id=Y

        - delete Comment X                                  /index.php/Comment/comment_id=X
    
    Moderator:
        - delete Event X                                    /index.php/Event/event_id=X
        - delete Location X                                 /index.php/Location/location_id=X
        - delete Category X                                 /index.php/Category/name=X

        - delete Comment X                                  /index.php/Comment/comment_id=X
        -- User can only delete his own Comment, Moderator can delete any Comment
    
    Administrator:
        - delete Account X                                  /index.php/Comment/email=X
        -- User can only delete his own Account, Administrator can delete any Account
