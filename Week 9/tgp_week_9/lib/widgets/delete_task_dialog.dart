import 'package:flutter/material.dart';

class DeleteTaskDialog extends StatefulWidget {
  const DeleteTaskDialog({super.key});

  @override
  State<DeleteTaskDialog> createState() => _DeleteTaskDialogState();
}

class _DeleteTaskDialogState extends State<DeleteTaskDialog> {
  @override
  Widget build(BuildContext context) {
    return Dialog(
      child: Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Flexible(
                child: Text(
                  "Are You Sure to delete this task?",
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    overflow: TextOverflow.visible,
                  ),
                ),
              ),
            ],
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
                  child: Text("Cancel", style: TextStyle(color: Colors.red)),
                ),
              ),
              SizedBox(width: 24),
              Expanded(
                child: TextButton(
                  onPressed: () {
                    debugPrint("Task Deleted");
                    Navigator.pop(context);
                  },
                  child: Text("Delete", style: TextStyle(color: Colors.blue)),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
