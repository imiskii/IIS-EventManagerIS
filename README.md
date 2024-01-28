# IIS Event Manager IS

## Brief

This project aimed to develop an information system based on an assignment.

## Used technologies

+ Front-end: HTML, CSS, JavaScript
+ Back-end: PHP
+ Database: MySQL


## Assignment

The task of the assignment is to create a simple information system for managing events organized by users of the information system (e.g. concert, performance, lecture, meeting of programmers, demonstrations, etc.). Each event has a unique label, with which users will be able to distinguish it appropriately, date/time of the event (from, to), venue, capacity (limited/unlimited), optional entrance fee (there may be more categories of entrance fee according to the organizer's requirements), category and other appropriate attributes (e.g. description, icon, photos, etc.). The venue is defined by its address and other appropriate attributes (description, photos, etc.). Categories have a hierarchical character (e.g. education -> seminar). Based on these categories, users can search for new events, register for events and add them to their calendar. Users will be able to use the information system in the following way:

+ administrator
    - manages users
    - has the rights of all the following roles
+ moderator
    - approves events
    - approves venues and administers them
    - approves categories and manages them
    - moderates event comments
+ registered user
    - scrolls through a personal calendar of events
    - creates events - becomes an event administrator
        + sends event approval requests
        + proposes new venues to the catalog of existing venues
        + suggests new event categories
        + confirms the payment of the entrance fee in advance, if it is required in the given event
    - registers for the event - becomes a participant in the event
        + evaluates and comments on events after their completion
+ unregistered user
    - going through events