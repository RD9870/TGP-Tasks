import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:saees_cards/helpers/functions_helper.dart';

class SplashScreen extends StatelessWidget {
  const SplashScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Image.asset(
          "assets/logoOnly.png",
          width: getSize(context).width * 0.5,
        ).animate().fadeIn(delay: 300.ms, duration: 600.milliseconds),
      ),
    );
  }
}
