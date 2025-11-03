// Challenge 1: Library Management System
// • Requirements:
// • Class Book with attributes: title, author, available (boolean).
// • Class Member with attributes: name, id, borrowed_books (list).
// • Class Library to manage books and members.
// ■ Methods:
// ● add_book()
// ● register_member()
// ● borrow_book(member_id)
// ● return_book(member_id)

class Book{
    id; title; author; available;
    constructor(book_id, book_title, book_author, isBookAvailable){
        this.id = book_id;
        this.title = book_title; 
        this.author = book_author; 
        this.available = isBookAvailable;
    }
}

class Member{
    name; id; borrowed_books;
    constructor(member_name, member_id, member_borrowed_books){
        this.name = member_name; 
        this.id = member_id; 
        this.borrowed_books = member_borrowed_books;
    }
}

class Library{
    books = [];
    members = [];

//add a book id 
    add_book(book_id, book_title, book_author, isBookAvailable){
        newBook = Book(book_id, book_title, book_author, isBookAvailable);
    }

    register_member(member_name, member_id, member_borrowed_books){
        newMember = Member(member_name, member_id, member_borrowed_books);
    }

//add book id to know which book is being borrowed
    borrow_book(member_id,book_id){

    }
//add book id to know which book is being returned
return_book(member_id){}
}


function main(){

    lib = new Library;
    lib.add_book("The Great Gatsby", "F. Scott Fitzgerald", true);
    lib.register_member("John Doe", 1, []);
}
