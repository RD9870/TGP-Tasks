import 'dart:convert';

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

  // factory TaskModel.fromRawJson(String str) =>
  //     TaskModel.fromJson(json.decode(str));

  // String toRawJson() => json.encode(toJson());

  factory TaskModel.fromJson(Map<String, dynamic> json) => TaskModel(
    id: json["id"],
    title: json["title"],
    subTitle: json["sub_title"],
    isCompleted: json["is_completed"],
    createdAt: json["created_at"],
  );

  static Map<String, dynamic> toJson(TaskModel task) => {
    "id": task.id,
    "title": task.title,
    "sub_title": task.subTitle,
    "is_completed": task.isCompleted,
    "created_at": task.createdAt,
  };

  static String encode(List<TaskModel> tasks) => json.encode(
    tasks.map<Map<String, dynamic>>((task) => TaskModel.toJson(task)).toList(),
  );

  static List<TaskModel> decode(String tasks) =>
      (json.decode(tasks) as List<dynamic>)
          .map<TaskModel>((item) => TaskModel.fromJson(item))
          .toList();
}
