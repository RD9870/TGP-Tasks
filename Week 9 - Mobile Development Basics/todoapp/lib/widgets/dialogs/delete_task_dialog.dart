import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:todoapp/models/task_model.dart';
import 'package:todoapp/providers/tasks_provider.dart';

class DeleteTaskDialog extends StatelessWidget {
  const DeleteTaskDialog({super.key, required this.taskModel});
  final TaskModel taskModel;
  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      // title
      title: Text("Delete Task"),
      content: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          // subtitle
          Text("Are you sure yo want to delete ${taskModel.title} ?"),
          SizedBox(height: 24),
          // action btns
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              // cancel btn
              Expanded(
                child: TextButton(
                  onPressed: () {
                    Navigator.pop(context);
                  },
                  child: Text("Cancel", style: TextStyle(color: Colors.red)),
                ),
              ),
              SizedBox(width: 24),
              // delete btn
              Expanded(
                child: ElevatedButton(
                  onPressed: () {
                    Provider.of<TasksProvider>(
                      context,
                      listen: false,
                    ).deleteTask(taskModel);
                    Navigator.pop(context);
                  },
                  child: Text("Delete"),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
