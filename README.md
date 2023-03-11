#### MVC

- Modal
    * Brief --> Handles business logic and data management

    * Manages the data of the application
    * Can process and store the data
    * Data can be stored in a database or any other data structure or storage system


- Controller
    * Middleman between Views and Model
    * Deal with requests, responses and handle resources e.t.c
    

- View
    * Renders/displays information to the screen
    * They are mostly PHP files containing HTML Markup
    * Templating Engines e.g. Twig and Blade are utilized by Views.



#### Notes

- Model takes information from the controller and pass it down to a datastore, 
retrieve data from the datastore and send it back to the controller. 

- Controller passes information to the View. 

- View then renders/display it to the screen


![MVC Image](/MVC.png "MVC Diagram").
