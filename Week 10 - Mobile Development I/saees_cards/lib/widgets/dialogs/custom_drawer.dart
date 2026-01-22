import 'package:flutter/material.dart';
import 'package:saees_cards/helpers/consts.dart';

class CustomDrawer extends StatelessWidget {
  const CustomDrawer({super.key});

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: SafeArea(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            ListTile(
              selectedColor: primaryColor,
              selected: true,
              leading: Icon(Icons.wallet),
              title: Text("Wallet"),
            ),
            ListTile(
              selectedColor: primaryColor,
              selected: false,
              leading: Icon(Icons.receipt),
              title: Text("Invoices"),
            ),
            SizedBox(height: 8),
          ],
        ),
      ),
    );
  }
}






          //   bottomNavigationBar: BottomNavigationBar(
          //   selectedItemColor: primaryColor,
          //   unselectedItemColor: Colors.grey,
          //   selectedLabelStyle: labelSmall.copyWith(color: primaryColor),
          //   unselectedLabelStyle: labelSmall.copyWith(color: primaryColor),

          //   currentIndex: currentIndex,

          //   onTap: (value) {
          //     setState(() {
          //       currentIndex = value;
          //     });
          //   },
          //   items: [
          //     BottomNavigationBarItem(
          //       label: "Wallet",
          //       icon: Icon(Icons.wallet),
          //     ),
          //     BottomNavigationBarItem(
          //       label: "Invoices",
          //       icon: Icon(Icons.receipt),
          //     ),
          //   ],
          // ),