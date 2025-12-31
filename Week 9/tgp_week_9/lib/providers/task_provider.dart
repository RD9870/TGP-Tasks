import 'package:flutter/material.dart';
import 'package:tgp_week_9/models/task_model.dart';

class TasksProvider with ChangeNotifier {
  List<Taskmodel> tasks = [];

  void addNewTask(Taskmodel tm) {
    tasks.add(tm);
    notifyListeners();
  }

  void deleteTask(Taskmodel tm) {
    tasks.remove(tm);
    notifyListeners();
  }

  //TODO Task 1
  void switchTask(Taskmodel tm) {
    tasks.firstWhere((e) => e.createdAt == tm.createdAt).isCompletes = !tasks
        .firstWhere((e) => e.createdAt == tm.createdAt)
        .isCompletes;
    notifyListeners();
  }

  // TODO Task 2
  void checkNameDuplication() {}
}
