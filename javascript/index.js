/**
 * Contains logic for database calls and generating (four) post elements.
 */

// Class to hold post data recieved from database.
class Post {
    title;
    date;
    content;
    constructor(title, date, content) {
        this.title = title;
        this.date = date;
        this.content = content;
    }
}

/**
 * Retrieve data from 'backend'. 
 * @returns an array of Post instances.
 */
function retrieveData() {
    // Approach for Assignment 2
    // Retrieve data and put into an array of temporary objects
    // Retrieval also sorts by date. [database stores post dates as yyyy-mm-dd (ISO format)]
    // Consider converting date into readable format (Day FullMonthName Year)
    
    // Approach for Assignment 1
    // hard code. Assume data was sorted with a sql query.
    // convert date to specification.
    let posts = [
        new Post("Introduction",
        "7 March 2022", 
        "This unit provides students with the knowledge, understanding, and skills required to develop an application system which uses a web interface to a back-end database. The unit assumes a sound basic knowledge of programming and database concepts and skills as developed in the introductory units in these areas. The emphasis in the unit is on mastery of the key concepts and the basic knowledge and skills required to build this kind of application. The unit will provide students with an awareness of the wide range of technologies which are used to support this kind of application but will examine only a limited number of these technologies to demonstrate the key concepts and their application. The unit explores the purposes and approaches in using scripting and mark-up languages in relation to the client-server paradigm. The role of both server-side and client-side code are examined. Students will study the use of mark-up and scripting programming languages to connect to databases via a network."),
        new Post("Communication",
        "2 March 2022",
        "Updates and announcements will be posted to the unit MyLO page. You are expected to be aware of the content of such posts within 48 hours of them being posted. Not monitoring unit communications is not a valid reason for requesting an extension or for not being aware of any changes.\
        \nPlease refer to the information provided on MyLO before asking a question related to the unit. Questions that are not answered on MyLO should be asked during consultation times, tutorials/lectures, or, as a final option, directed to the Unit Coordinator via email."),
        new Post("Unit web site", 
        "27 February 2022",
        "MyLO is the online learning environment at the University of Tasmania. This is the system that will host the online learning materials and activities for this unit. It is important that you are able to access and use MyLO as part of your study in this unit. To find out more about the features and functions of MyLO, and to practice using them, visit the ‘Getting Started in MyLO’ unit."),
        new Post("Developing attainment of SFIA", 
        "17 February 2022", 
        "As an accredited Australian Computing Society (ACS) course, each unit offered in this ICT course assists students in the attainment of SFIA skills which can help you achieve your specific career goals. As you progress through the course you will develop depth with the skills at increasing levels of responsibility ranging from 1-5.")
    ]    
    return posts;
}


/**
 * Function to assist with building a list of html posts. 
 * @param {Post} data - A post retrieved from database.
 * @returns a post document element.
 */
function createPost(data) {
    let post = document.createElement("div");
    post.setAttribute("id", "post");

    // Create Post title as heading
    let item = document.createElement('h2'); // TODO: try different sizes OR custom tag.
    item.append(data.title);
    post.appendChild(item);
    
    // Create Post date
    item = document.createElement('p');
    item.setAttribute("id", "date");
    item.append(data.date);
    post.appendChild(item);
    
    // Setup for creating post content.    
    const regex = new RegExp("\n", "g");  
    let paragraphs = data.content.split(regex); // TODO: consider using const?

    // Create paragraph elements for non-empty paragraphs.
    for (var i = 0; i < paragraphs.length; i++) {        
        if (paragraphs[i].match(/\S/)) { // words exist, create parargraph.
            item = document.createElement('p');
            item.append(paragraphs[i]);
            post.appendChild(item);
        }
    }
    return post;
}

// Fill up mainSectoin div element with posts.
const mainDiv = document.getElementById("mainSection");
const posts = retrieveData(); 

for (var i = 0; i < posts.length; i++)
{
    mainDiv.appendChild(createPost(posts[i]));
}
