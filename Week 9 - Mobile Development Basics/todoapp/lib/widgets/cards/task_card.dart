import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:todoapp/models/task_model.dart';
import 'package:todoapp/providers/tasks_provider.dart';
import 'package:todoapp/screen/task_details_screen.dart';
import 'package:todoapp/widgets/dialogs/delete_task_dialog.dart';

class TaskCard extends StatelessWidget {
  const TaskCard({super.key, required this.taskModel});
  final TaskModel taskModel;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => TaskDetailsScreen(taskModel: taskModel),
          ),
        );
      },

      onLongPress: () {
        showDialog(
          context: context,
          builder: (context) => DeleteTaskDialog(taskModel: taskModel),
        );
      },

      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        child: AnimatedContainer(
          duration: Duration(milliseconds: 300),
          decoration: BoxDecoration(
            color: taskModel.isCompleted
                ? Colors.blue.withValues(alpha: 0.5)
                : Colors.blue,

            borderRadius: BorderRadius.circular(12),
          ),
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: Column(
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Row(
                      children: [
                        Icon(Icons.task, color: Colors.white),
                        SizedBox(width: 4),
                        Text(
                          taskModel.title,
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                            decoration: taskModel.isCompleted
                                ? TextDecoration.lineThrough
                                : TextDecoration.none,
                          ),
                        ),
                      ],
                    ),

                    Checkbox(
                      value: taskModel.isCompleted,
                      onChanged: (v) {
                        Provider.of<TasksProvider>(
                          context,
                          listen: false,
                        ).switchTask(taskModel.id);
                      },
                    ),
                  ],
                ),

                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      taskModel.subTitle.toString(),
                      style: TextStyle(
                        color: Colors.white,
                        decoration: taskModel.isCompleted
                            ? TextDecoration.lineThrough
                            : TextDecoration.none,
                      ),
                    ),

                    Text(
                      taskModel.createdAt.substring(0, 10).replaceAll("-", "/"),
                      style: TextStyle(
                        color: Colors.white,
                        decoration: taskModel.isCompleted
                            ? TextDecoration.lineThrough
                            : TextDecoration.none,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
