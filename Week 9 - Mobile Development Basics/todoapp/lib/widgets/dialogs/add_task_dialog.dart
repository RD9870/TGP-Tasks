import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:todoapp/models/task_model.dart';
import 'package:todoapp/providers/dark_mode_provider.dart';
import 'package:todoapp/providers/tasks_provider.dart';
import 'package:uuid/uuid.dart';

class AddTaskDialog extends StatefulWidget {
  const AddTaskDialog({super.key});

  @override
  State<AddTaskDialog> createState() => _AddTaskDialogState();
}

class _AddTaskDialogState extends State<AddTaskDialog> {
  GlobalKey<FormState> formKey = GlobalKey<FormState>();
  TextEditingController titleController = TextEditingController();
  TextEditingController subtitleController = TextEditingController();
  var uuid = Uuid();

  @override
  Widget build(BuildContext context) {
    return Consumer2<TasksProvider, DarkModeProvider>(
      builder: (context, tasksConsumer, darkModeConsumer, _) {
        return Dialog(
          child: Padding(
            padding: const EdgeInsets.all(24.0),
            child: Form(
              key: formKey,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Row(
                    children: [
                      Text(
                        "Add New Task",
                        style: TextStyle(
                          fontSize: 20,
                          color: darkModeConsumer.isDark
                              ? Colors.white
                              : Colors.black,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ],
                  ),
                  SizedBox(height: 20),

                  TextFormField(
                    decoration: InputDecoration(hint: Text("Title")),
                    controller: titleController,
                    autofocus: true,
                    validator: (value) {
                      if (value == null) {
                        return "Title is Required!";
                      }
                      if (value.length <= 2) {
                        return "Title must be more that 2 Chars!";
                      }
                      bool isDube = tasksConsumer.checkNameDuplication(value);
                      if (isDube) {
                        return "Dublicate Title, please change it!";
                      }
                      return null;
                    },
                  ),
                  SizedBox(height: 20),
                  TextFormField(
                    controller: subtitleController,
                    decoration: InputDecoration(hint: Text("Subtitle")),
                    validator: (value) {
                      if (value == null) {
                        return "Subtitle is Required!";
                      }
                      if (value.length <= 2) {
                        return "Subtitle must be more that 2 Chars!";
                      }
                      return null;
                    },
                  ),
                  SizedBox(height: 24),

                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Expanded(
                        child: TextButton(
                          onPressed: () {
                            Navigator.pop(context);
                          },
                          child: Text(
                            "Cancel",
                            style: TextStyle(color: Colors.red),
                          ),
                        ),
                      ),
                      SizedBox(width: 24),
                      Expanded(
                        child: ElevatedButton(
                          onPressed: () {
                            if (formKey.currentState!.validate()) {
                              tasksConsumer.addNewTask(
                                TaskModel(
                                  id: uuid.v4(),
                                  title: titleController.text,
                                  subTitle: subtitleController.text,
                                  createdAt: DateTime.now().toIso8601String(),
                                ),
                              );
                              titleController.clear();
                              subtitleController.clear();
                              Navigator.pop(context);
                            }
                          },
                          child: Text("ADD"),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }
}
