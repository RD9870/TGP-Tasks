import 'dart:async';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/helpers/functions_helper.dart';
import 'package:tgp_games/screens/main_screens/home_screen.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: getSize(context).width,
        height: getSize(context).height,
        decoration: BoxDecoration(
          gradient: LinearGradient(colors: [primaryColor, purpleColor]),
        ),
        child: Center(
          child:
              Image.asset(
                    "assets/stupidLogo.png",

                    width: getSize(context).width * 0.75,
                  )
                  .animate(
                    onComplete: (controller) {
                      Timer(Duration(seconds: 1), () {
                        Navigator.pushReplacement(
                          context,
                          CupertinoPageRoute(
                            builder: (context) => HomeScreen(),
                          ),
                        );
                      });
                    },
                  )
                  .fadeIn(
                    delay: animationDuration * 3,
                    duration: animationDuration * 2,
                  )
                  .scaleX(
                    delay: animationDuration * 3,

                    duration: animationDuration,
                    begin: 0.9,
                    end: 1,
                  ),
        ),
      ),
    );
  }
}
