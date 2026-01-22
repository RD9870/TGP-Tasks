import 'package:flutter/material.dart';

class Wrong extends StatefulWidget {
  const Wrong({super.key});

  @override
  State<Wrong> createState() => _WrongState();
}

class _WrongState extends State<Wrong> {
  @override
  Widget build(BuildContext context) {
    return const Scaffold(body: Center(child: Text("Something went wrong!")));
  }
}
