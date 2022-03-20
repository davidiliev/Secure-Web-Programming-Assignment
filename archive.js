/**
 * Contains logic for database calls and generating (four) post elements.
 */

// Class to hold post data recieved from database.
class ArchivedPost {
    title;
    date;
    content;
    constructor(title, date) {
        this.title = title;
        this.date = date;
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
        new ArchivedPost("Generic graduate attributes",
        "10 February 2022"),
        new ArchivedPost("Computing facilities",
        "6 February 2022"),
        new ArchivedPost("Safety and Wellbeing",
        "ArchivedPost"),
        new ArchivedPost("Academic Integrity Training Module",
        "20 January 2022"),
        new ArchivedPost("Further information and assistance",
        "20 January 2022")
    ]    
    return posts;
}


/**
 * Function to assist with building a list of html posts. 
 * @param {ArchivedPost} data - A post retrieved from database.
 * @returns a post document element.
 */
function createPost(data) {
    let post = document.createElement("post");

    // Create Post title as heading
    let item = document.createElement('h2'); // TODO: try different sizes OR custom tag.
    item.append(data.title);
    post.appendChild(item);
    
    // Create Post date
    item = document.createElement('p');
    item.append(data.date);
    post.appendChild(item);

    // ALTERNATIVELY: display in a table.
    // title aligned left within left cell
    // date aligned right within right cell
    
    return post;
}

// Fill up page with posts.
const mainDiv = document.getElementById("mainSection");
const posts = retrieveData(); 
for (var i = 0; i < posts.length; i++)
{
    mainDiv.appendChild(createPost(posts[i]));
}
