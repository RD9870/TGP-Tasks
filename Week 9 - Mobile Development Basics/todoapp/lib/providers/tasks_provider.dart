import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:todoapp/models/task_model.dart';

class TasksProvider with ChangeNotifier {
  List<TaskModel> tasks = [];

  // add a task to the list
  Future<void> addNewTask(TaskModel tm) async {
    tasks.add(tm);
    await storeToLocalStorage();
    notifyListeners();
  }

  // remove a task from the list
  void deleteTask(TaskModel tm) {
    tasks.remove(tm);
    notifyListeners();
  }

  // todo TASK 1 DONE
  // check and uncheck the task
  void switchTask(String id) async {
    TaskModel? task = tasks.where((element) => element.id == id).firstOrNull;
    if (task != null) {
      task.isCompleted = !task.isCompleted;
      await storeToLocalStorage();
    }
    notifyListeners();
  }

  // todo TASK 2 DONE
  // check if the task already exsists
  bool checkNameDuplication(String title) {
    if (tasks.any(((task) => task.title == title))) {
      return true;
    } else {
      return false;
    }
  }

  // todo TASK 3 DONE
  // add the tasks list to the local storage
  Future<void> storeToLocalStorage() async {
    // to store the task in the local storage
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    // encode means take the tasks list and return it as a string
    String taskData = TaskModel.encode(tasks);
    await prefs.setString("tasks", taskData);
  }

  // todo TASK 4 DONE
  // get the tasks list from the local storage
  Future<List<TaskModel>?> fetchFromLocalStorage() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    String? savedTasks = prefs.getString("tasks");
    // if the saved tasks exsists and is not empty
    if (savedTasks != null && savedTasks != "") {
      // turn it into a list of TaskModel objects
      tasks = TaskModel.decode(savedTasks);
      return tasks;
    } else {
      return null;
    }
  }

  // empty the tasks list saved in the local storage
  Future<void> clearSharedPrefs() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    tasks = [];
    await prefs.setString("tasks", "");
    notifyListeners();
  }
}
