// from https://quicktype.io/
// define the object expected from the backend

class Taskmodel {
  String title;
  String? subtitle;
  bool isCompletes;
  DateTime createdAt;

  Taskmodel({
    required this.title,
    this.subtitle,
    this.isCompletes = false,
    required this.createdAt,
  });
}
