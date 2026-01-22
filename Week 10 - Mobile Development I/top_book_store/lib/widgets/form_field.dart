import 'package:flutter/material.dart';

class AuthorFormField extends StatelessWidget {
  final String txt;
  final FormFieldValidator<String> validate;
  final TextEditingController controller;
  final bool? isLarge;

  const AuthorFormField({
    super.key,
    required this.txt,
    required this.validate,
    required this.controller,
    this.isLarge,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 8.0, vertical: 16.0),
      child: TextFormField(
        decoration: InputDecoration(
          hintText: txt.toUpperCase(),
          border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
        ),
        validator: validate,
        controller: controller,
        maxLines: isLarge == true ? 5 : 1,
      ),
    );
  }
}
