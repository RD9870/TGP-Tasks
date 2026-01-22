import 'package:flutter/material.dart';
import 'package:tgp_week_9/models/task_model.dart';
import 'package:tgp_week_9/widgets/add_task_dialog.dart';
import 'package:tgp_week_9/widgets/task_card.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  TextEditingController titleCtrl = TextEditingController();
  TextEditingController subTitleCtrl = TextEditingController();

  @override
  void initState() {
    super.initState();
  }

  @override
  void dispose() {
    titleCtrl.dispose();
    subTitleCtrl.dispose();
    super.dispose();
  }

  List<Taskmodel> tasks = [
    Taskmodel(title: "task 1", createdAt: DateTime.now()),
    Taskmodel(
      title: "task 2",
      createdAt: DateTime.now(),
      subtitle: "task 2 sub",
    ),
    Taskmodel(title: "task 3", createdAt: DateTime.now()),
    Taskmodel(title: "task 4", createdAt: DateTime.now(), isCompletes: true),
    Taskmodel(
      title: "task 5",
      createdAt: DateTime.now(),
      subtitle: "task 5 sub",
    ),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        centerTitle: true,
        title: Text(
          "TODO APP",
          style: TextStyle(
            color: Colors.white,
            fontSize: 24,
            fontWeight: FontWeight.bold,
          ),
        ),
        backgroundColor: Colors.blue,
      ),
      body: Center(
        child: DefaultTabController(
          length: 3,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              TabBar(
                tabs: [
                  Tab(child: Text("All")),
                  Tab(child: Text("In Progress")),
                  Tab(child: Text("Completed")),
                ],
              ),
              Expanded(
                child: TabBarView(
                  children: [
                    ListView.builder(
                      itemCount: tasks.length,
                      padding: EdgeInsets.symmetric(vertical: 8),
                      itemBuilder: (BuildContext context, int index) {
                        return TaskCard(
                          tasModel: tasks[index],
                          onSwich: () {
                            setState(() {
                              tasks[index].isCompletes =
                                  !tasks[index].isCompletes;
                            });
                          },
                        );
                      },
                    ),
                    // Center(child: Text("All")),
                    Center(child: Text("In-Progress")),
                    Center(child: Text("Completed")),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: () {
          openAddTask();
        },
      ),
    );
  }

  Future openAddTask() {
    return showDialog(
      context: context,
      builder: (context) => AlertDialog(content: AddTaskDialog()),
    );
  }

  // void addTaskToList() {
  //   String title = titleCtrl.text;
  //   String? subTitle = subTitleCtrl.text;
  //   if (subTitle == "") {
  //     subTitle = null;
  //   }
  //   Taskmodel newTask = Taskmodel(
  //     title: title,
  //     subtitle: subTitle,
  //     createdAt: DateTime.now(),
  //   );

  //   setState(() {
  //     tasks.add(newTask);
  //   });
  //   Navigator.pop(context);
  //   subTitleCtrl.clear();
  //   titleCtrl.clear();
  // }
}
