import 'package:flutter/material.dart';
import 'package:todoapp/models/task_model.dart';

class TaskDetailsScreen extends StatefulWidget {
  const TaskDetailsScreen({super.key, required this.taskModel});

  final TaskModel taskModel;

  @override
  State<TaskDetailsScreen> createState() => _TaskDetailsScreenState();
}

class _TaskDetailsScreenState extends State<TaskDetailsScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(),
      body: Center(
        child: SafeArea(
          child: Column(
            children: [
              Text(widget.taskModel.title),
              Text(widget.taskModel.subTitle),

              Icon(
                widget.taskModel.isCompleted ? Icons.check : Icons.close,
                size: 200,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
