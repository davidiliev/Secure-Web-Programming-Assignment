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
        "This unit provides students with the knowledge, understanding, and skills ..."),
        new Post ("Communication",
        "2 March 2022",
        "Updates and announcements will be posted to the unit MyLO  ... "),
        new Post("Unit web site", 
        "27 February 2022",
        "MyLO is the online learning environment at the University of Tasmania ..."),
        new Post("Developing attainment of SFIA", 
        "17 February 2022", 
        "As an accredited Australian Computing Society (ACS) course, ...")
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
    // Create Post date
    item = document.createElement('p');
    item.append(data.content);
    post.appendChild(item);
    return post;
}

// Fill up mainSectoin div element with posts.
const mainDiv = document.getElementById("mainSection");
const posts = retrieveData(); 

for (var i = 0; i < posts.length; i++)
{
    mainDiv.appendChild(createPost(posts[i]));
}
