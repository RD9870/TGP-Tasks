import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:toastification/toastification.dart';
import 'package:top_book_store/helpers/consts.dart';
import 'package:top_book_store/providers/auth_provider.dart';
import 'package:top_book_store/screens/main_screens/home_screen.dart';
import 'package:top_book_store/widgets/form_field.dart';
import 'package:flutter/foundation.dart';
import 'package:provider/provider.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  TextEditingController userNameCtrl = TextEditingController(
    text: kDebugMode ? "testAuthor" : "",
  );
  TextEditingController passwordCtrl = TextEditingController(
    text: kDebugMode ? "password" : "",
  );
  final GlobalKey<FormState> formKey = GlobalKey<FormState>();
  @override
  Widget build(BuildContext context) {
    return Consumer<AuthProvider>(
      builder: (context, authConsumer, _) {
        return Scaffold(
          body: Stack(
            fit: StackFit.expand,
            children: [
              Image.asset("assets/loginBG.jpg", fit: BoxFit.cover),
              Center(
                child: Container(
                  margin: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: whiteColor.withValues(alpha: 0.8),
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Center(
                          child: Text(
                            "Welcome Back!",
                            style: TextStyle(
                              fontSize: 20,
                              color: primaryColor,
                              fontFamily: GoogleFonts.getFont(
                                'Knewave',
                              ).fontFamily,
                            ),
                          ),
                        ),
                        Form(
                          key: formKey,
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              AuthorFormField(
                                txt: "userName",
                                validate: (validate) {
                                  if (validate == null || validate.isEmpty) {
                                    return "Please enter your user name";
                                  }
                                  return null;
                                },
                                controller: userNameCtrl,
                              ),

                              AuthorFormField(
                                txt: "password",
                                validate: (validate) {
                                  if (validate == null || validate.isEmpty) {
                                    return "Please enter your password";
                                  } else if (validate.length < 2) {
                                    return "Password must be at least 2 characters long";
                                  }
                                  return null;
                                },
                                controller: passwordCtrl,
                              ),
                            ],
                          ),
                        ),
                        Column(
                          children: [
                            ElevatedButton(
                              style: ElevatedButton.styleFrom(
                                backgroundColor: primaryColor,
                                foregroundColor: whiteColor,
                              ),
                              onPressed: authConsumer.busy
                                  ? () {}
                                  : () {
                                      if (formKey.currentState!.validate()) {
                                        authConsumer
                                            .login({
                                              "username": userNameCtrl.text,
                                              "password": passwordCtrl.text,
                                            })
                                            .then((value) {
                                              if (value[0] == true) {
                                                toastification.show(
                                                  type: ToastificationType
                                                      .success,
                                                  style: ToastificationStyle
                                                      .flatColored,
                                                  title: Text(value[1]),
                                                  autoCloseDuration:
                                                      const Duration(
                                                        seconds: 5,
                                                      ),
                                                );

                                                if (!context.mounted) return;

                                                Navigator.pushReplacement(
                                                  context,
                                                  MaterialPageRoute(
                                                    builder: (context) =>
                                                        const HomeScreen(),
                                                  ),
                                                );
                                              } else {
                                                toastification.show(
                                                  type:
                                                      ToastificationType.error,
                                                  style: ToastificationStyle
                                                      .flatColored,
                                                  title: Text(value[1]),
                                                  autoCloseDuration:
                                                      const Duration(
                                                        seconds: 5,
                                                      ),
                                                );
                                              }
                                            });
                                      }
                                    },
                              child: authConsumer.busy
                                  ? SizedBox(
                                      height: 25,
                                      width: 25,
                                      child: CircularProgressIndicator(
                                        color: whiteColor,
                                      ),
                                    )
                                  : Text("Author Login"),
                            ),

                            TextButton(
                              onPressed: () {
                                if (!context.mounted) return;

                                Navigator.pushReplacement(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) => const LoginScreen(),
                                  ),
                                );
                              },
                              child: Text("Don't have an account? Register"),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ],
          ),
        );
      },
    );
  }
}
