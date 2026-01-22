import 'package:flutter/material.dart';
import 'package:saees_cards/helpers/consts.dart';
import 'package:saees_cards/widgets/statics/dashed_separator.dart';

class TransactionDetails extends StatelessWidget {
  final String username;
  final String type;
  final String ammount;
  final String refrence;
  final String? description;

  const TransactionDetails({
    super.key,
    required this.username,
    required this.type,
    required this.ammount,
    required this.refrence,
    this.description,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: primaryColor.withValues(alpha: 0.15),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: primaryColor.withValues(alpha: 0.15)),
      ),
      margin: EdgeInsets.all(12),
      child: Center(
        child: SizedBox(
          // height: 450,
          // width: 450,
          child: Stack(
            children: [
              Padding(
                padding: const EdgeInsets.symmetric(
                  horizontal: 16.0,
                  vertical: 24.0,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: Text(
                            "Transaction Details",
                            style: TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                        Row(
                          mainAxisSize: MainAxisSize.max,
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text(username, style: TextStyle(fontSize: 17)),
                            Spacer(),
                            Text(
                              type,
                              style: TextStyle(fontSize: 15, color: grayColor),
                            ),
                          ],
                        ),
                      ],
                    ),
                    const SizedBox(height: 26),
                    const DashedSeparator(color: Colors.grey),
                    const SizedBox(height: 24),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text(
                          "$ammount LYD",
                          style: TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        Text(
                          refrence,
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.w300,
                          ),
                        ),
                      ],
                    ),
                    description != null
                        ? Text(description!, style: TextStyle(fontSize: 16))
                        : SizedBox(),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
