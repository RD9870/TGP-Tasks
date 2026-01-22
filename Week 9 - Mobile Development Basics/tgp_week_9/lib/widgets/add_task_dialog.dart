import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:tgp_week_9/models/task_model.dart';
import 'package:tgp_week_9/providers/task_provider.dart';

class AddTaskDialog extends StatefulWidget {
  const AddTaskDialog({super.key});

  @override
  State<AddTaskDialog> createState() => _AddTaskDialogState();
}

class _AddTaskDialogState extends State<AddTaskDialog> {
  GlobalKey<FormState> formKey = GlobalKey();
  final TextEditingController titleCtrl = TextEditingController();
  final TextEditingController subTitleCtrl = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Dialog(
      child: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Form(
          key: formKey,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Row(
                children: [
                  Text(
                    "Add New Task",
                    style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
              SizedBox(height: 20),
              TextFormField(
                controller: titleCtrl,
                decoration: InputDecoration(label: Text("Task Title")),
                validator: (val) {
                  if (val == null) {
                    return "title is required";
                  }
                  if (val.length <= 2) {
                    return "title must be longer than 2 chars";
                  }
                  return null;
                },
              ),
              SizedBox(height: 20),
              TextFormField(
                controller: subTitleCtrl,
                decoration: InputDecoration(label: Text("Task Subtitle")),
                validator: (val) {
                  if (val == null) {
                    return "subtitle is required";
                  }
                  if (val.length <= 2) {
                    return "subtitle must be longer than 2 chars";
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
                    child: TextButton(
                      onPressed: () {
                        if (formKey.currentState!.validate()) {
                          Provider.of<TasksProvider>(
                            context,
                            listen: false,
                          ).addNewTask(
                            Taskmodel(
                              title: titleCtrl.text,
                              subtitle: subTitleCtrl.text.isEmpty
                                  ? ""
                                  : subTitleCtrl.text,
                              createdAt: DateTime.now(),
                            ),
                          );
                          titleCtrl.clear();
                          subTitleCtrl.clear();
                          Navigator.pop(context);
                        }
                      },
                      child: Text("Add", style: TextStyle(color: Colors.blue)),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
