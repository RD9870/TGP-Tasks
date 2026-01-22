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
        this.available = true;
    }
}

class Member{
    name; id; borrowed_books;
    constructor(member_name, member_id){
        this.name = member_name; 
        this.id = member_id; 
        this.borrowed_books = [];
    }
}

class Library{
    books = [];
    members = [];

//add a book id 
    add_book(book_id, book_title, book_author){
        let newBook = new Book(book_id, book_title, book_author);
        this.books.push(newBook);
    }

    register_member(member_name, member_id){
        let newMember = new Member(member_name, member_id);
        this.members.push(newMember);
    }

//add book id to know which book is being borrowed
    borrow_book(member_id,book_id){
        let member = this.members.find((mem)=> mem.id == member_id);
        let book = this.books.find((bk)=> bk.id == book_id);
        if(book.available == true){
            member.borrowed_books.push(book.id);
            book.available = false;
            console.log(`The Book ${book.title} has been added to the member's ${member.name} borrowed list`);
        }
        else{
            console.log(`Sorry, this book ${book.title} is not Avaliable to add to the user ${member.name} right now`);
        }
    }
//add book id to know which book is being returned
return_book(member_id,book_id){
        let member = this.members.find((mem)=> mem.id == member_id);
        console.log('member borrowed list\n' + member.borrowed_books);
        let bookinList = member.borrowed_books. includes(book_id);
        console.log('bookinList = ' + bookinList);
        if(bookinList == true){
            member.borrowed_books.pop(bookinList.id);
            let book = this.books.find((bk)=> bk.id == book_id);
            book.available = true;
            console.log(`The member ${member.name} has returned this book`)
        }
        else {
            console.log(`Sorry, this member ${member.name} did not borrow this book`)
        }
}
}


function main(){

    lib = new Library;
    lib.add_book(1, "The Great Gatsby", "F. Scott Fitzgerald", true);
    lib.add_book(2, "harry potter", "jkr", true);
    lib.add_book(3, "percy jackson", "uncle ric", );
    
    lib.register_member("John Doe", 1);
    lib.register_member("Emma Doe", 2);

    console.log('let member borrow book')

// emma borrows the great gatsby sucsess
    lib.borrow_book(2,1)
//jhon borrows the greate gatsby fails
    lib.borrow_book(1,1)
//emma borrows harry potter sucsess
    lib.borrow_book(2,2)
//john borrows percy jackson sucsess
    lib.borrow_book(1,3)
    
    console.log(lib.members)
    // console.log(lib.books)


    console.log('let member return book')
//emma returns percy jackson fails
    lib.return_book(2,3);
//emma returns  the great gatsby sucsess
lib.return_book(2,1);
    //         console.log(lib.members)
    // console.log(lib.books)
        console.log(lib.members)

}

main();