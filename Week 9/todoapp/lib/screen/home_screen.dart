import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:todoapp/providers/dark_mode_provider.dart';
import 'package:todoapp/providers/tasks_provider.dart';
import 'package:todoapp/widgets/cards/task_card.dart';
import 'package:todoapp/widgets/dialogs/add_task_dialog.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  @override
  void initState() {
    // Provider.of<DarkModeProvider>(context, listen: false).getFromlocalStorage();
    Provider.of<TasksProvider>(context, listen: false).fetchFromLocalStorage();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Consumer2<TasksProvider, DarkModeProvider>(
      builder: (context, tasksConsumer, darkModeConsumer, _) {
        return Scaffold(
          drawer: Drawer(
            child: Column(
              children: [
                // TODO TASK 5 DarkMode Button + Clear SharedPrefrences Data DONE
                const DrawerHeader(
                  child: Text(
                    'Drawer Header',
                    style: TextStyle(
                      fontSize: 20,
                      color: Colors.blue,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
                ListTile(
                  leading: Icon(
                    darkModeConsumer.isDark
                        ? Icons.light_mode
                        : Icons.dark_mode,
                  ),
                  title: Text(
                    darkModeConsumer.isDark ? 'Light Mode' : 'Dark Mode',
                  ),
                  onTap: () {
                    darkModeConsumer.switchMode();
                    Navigator.pop(context);
                  },
                ),

                ListTile(
                  title: const Text('Clear Shared Prefrences'),
                  leading: Icon(Icons.delete),
                  onTap: () {
                    tasksConsumer.clearSharedPrefs();
                    Navigator.pop(context);
                  },
                ),
              ],
            ),
          ),
          appBar: AppBar(
            actions: [
              // IconButton(
              //   onPressed: () {
              //     darkModeConsumer.switchMode();
              //   },
              //   icon: Icon(
              //     darkModeConsumer.isDark ? Icons.light_mode : Icons.dark_mode,
              //   ),
              // ),
            ],
            centerTitle: true,
            title: Text(
              "TODO APP",
              style: TextStyle(
                color: Colors.white,
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),

          body: DefaultTabController(
            length: 3,
            child: Column(
              children: [
                TabBar(
                  tabs: [
                    Tab(text: "All"),
                    Tab(text: "In-Progress"),
                    Tab(text: "Completed"),
                  ],
                ),
                Expanded(
                  child: TabBarView(
                    children: [
                      ListView.builder(
                        itemCount: tasksConsumer.tasks.length,
                        padding: EdgeInsets.symmetric(vertical: 8),
                        itemBuilder: (context, index) {
                          return TaskCard(
                            taskModel: tasksConsumer.tasks[index],
                          );
                        },
                      ),
                      ListView.builder(
                        itemCount: tasksConsumer.tasks.length,
                        padding: EdgeInsets.symmetric(vertical: 8),
                        itemBuilder: (context, index) {
                          return tasksConsumer.tasks[index].isCompleted
                              ? SizedBox()
                              : TaskCard(taskModel: tasksConsumer.tasks[index]);
                        },
                      ),
                      ListView.builder(
                        itemCount: tasksConsumer.tasks.length,
                        padding: EdgeInsets.symmetric(vertical: 8),
                        itemBuilder: (context, index) {
                          return !tasksConsumer.tasks[index].isCompleted
                              ? SizedBox()
                              : TaskCard(taskModel: tasksConsumer.tasks[index]);
                        },
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          floatingActionButtonLocation:
              FloatingActionButtonLocation.centerFloat,
          floatingActionButton: FloatingActionButton(
            child: Icon(Icons.add),
            onPressed: () {
              showDialog(
                context: context,
                builder: (context) => AddTaskDialog(),
              );
            },
          ),
        );
      },
    );
  }
}
