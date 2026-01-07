import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:todoapp/models/task_model.dart';

class TasksProvider with ChangeNotifier {
  List<TaskModel> tasks = [];

  Future<void> addNewTask(TaskModel tm) async {
    tasks.add(tm);
    await storeToLocalStorage();
    notifyListeners();
  }

  void deleteTask(TaskModel tm) {
    tasks.remove(tm);
    notifyListeners();
  }

  // TODO TASK 1 DONE
  void switchTask(String id) async {
    TaskModel? task = tasks.where((element) => element.id == id).firstOrNull;
    if (task != null) {
      task.isCompleted = !task.isCompleted;
      await storeToLocalStorage();
    }
    notifyListeners();
  }

  // TODO TASK 2 DONE
  bool checkNameDuplication(String title) {
    if (tasks.any(((task) => task.title == title))) {
      return true;
    } else {
      return false;
    }
  }

  // TODO TASK 3 DONE
  Future<void> storeToLocalStorage() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    String taskData = TaskModel.encode(tasks);
    await prefs.setString("tasks", taskData);
  }

  // TODO TASK 4 DONE
  Future<List<TaskModel>?> fetchFromLocalStorage() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    String? savedTasks = prefs.getString("tasks");
    if (savedTasks != null && savedTasks != "") {
      tasks = TaskModel.decode(savedTasks);
      return tasks;
    } else {
      return null;
    }
  }

  Future<void> clearSharedPrefs() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    tasks = [];
    await prefs.setString("tasks", "");
    notifyListeners();
  }
}
