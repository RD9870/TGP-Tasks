import 'dart:convert';

// from https://quicktype.io/
// define the object expected from the backend

class TaskModel {
  String id;
  String title;
  String subTitle;
  bool isCompleted;
  String createdAt;

  TaskModel({
    required this.id,
    required this.title,
    required this.subTitle,
    this.isCompleted = false,
    required this.createdAt,
  });

  factory TaskModel.fromJson(Map<String, dynamic> json) => TaskModel(
    id: json["id"],
    title: json["title"],
    subTitle: json["sub_title"],
    isCompleted: json["is_completed"],
    createdAt: json["created_at"],
  );

  // convirt the object into a map (key value pairs)
  static Map<String, dynamic> toJson(TaskModel task) => {
    "id": task.id,
    "title": task.title,
    "sub_title": task.subTitle,
    "is_completed": task.isCompleted,
    "created_at": task.createdAt,
  };

  // converts a List of Tasks into a single String.
  static String encode(List<TaskModel> tasks) => json.encode(
    tasks.map<Map<String, dynamic>>((task) => TaskModel.toJson(task)).toList(),
  );

  // takes a JSON String and turns it back into a List of TaskModel objects.
  static List<TaskModel> decode(String tasks) =>
      (json.decode(tasks) as List<dynamic>)
          .map<TaskModel>((item) => TaskModel.fromJson(item))
          .toList();
}
