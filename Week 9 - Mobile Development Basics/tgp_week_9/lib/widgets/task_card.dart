import 'package:flutter/material.dart';
import 'package:tgp_week_9/models/task_model.dart';
import 'package:tgp_week_9/widgets/delete_task_dialog.dart';

class TaskCard extends StatelessWidget {
  const TaskCard({super.key, required this.tasModel, required this.onSwich});
  final Taskmodel tasModel;
  final Function onSwich;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onLongPress: () => {
        showDialog(
          context: context,
          builder: (context) => AlertDialog(content: DeleteTaskDialog()),
        ),
      },
      child: Padding(
        padding: EdgeInsetsGeometry.symmetric(vertical: 8, horizontal: 16),
        child: Container(
          decoration: BoxDecoration(
            color: Colors.blue,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Padding(
            padding: const EdgeInsetsGeometry.all(8),
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
                          tasModel.title,
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                      ],
                    ),
                    Checkbox(
                      value: tasModel.isCompletes,
                      onChanged: (v) {
                        onSwich();
                      },
                    ),
                  ],
                ),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    tasModel.subtitle != null
                        ? Text(
                            tasModel.subtitle.toString(),
                            style: TextStyle(color: Colors.white),
                          )
                        : SizedBox(),
                    Text(
                      tasModel.createdAt
                          .toIso8601String()
                          .substring(0, 10)
                          .replaceAll("-", "/"),
                      style: TextStyle(color: Colors.white),
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
