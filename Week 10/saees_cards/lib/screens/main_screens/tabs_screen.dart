import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:provider/provider.dart';
import 'package:saees_cards/helpers/consts.dart';
import 'package:saees_cards/providers/auth_provider.dart';
import 'package:saees_cards/providers/qr_provider.dart';
import 'package:saees_cards/providers/upload_image_provider.dart';
import 'package:saees_cards/screens/handling_screens/qr_scanner.dart';
import 'package:saees_cards/screens/main_screens/tabs_content/invoices_content.dart';
import 'package:saees_cards/screens/main_screens/tabs_content/wallet_content.dart';
import 'package:saees_cards/widgets/cickables/main_button.dart';
import 'package:saees_cards/widgets/dialogs/custom_drawer.dart';
import 'package:saees_cards/widgets/dialogs/flush_bar.dart';
import 'package:saees_cards/widgets/dialogs/pick_image_dialog.dart';

class TabsScreen extends StatefulWidget {
  const TabsScreen({super.key});

  @override
  State<TabsScreen> createState() => _TabsScreenState();
}

class _TabsScreenState extends State<TabsScreen> {
  int currentIndex = 0;
  @override
  Widget build(BuildContext context) {
    return Consumer3<AuthProvider, QrProvider, UploadImageProvider>(
      builder: (context, authConsumer, qrConsumer, imageConsumer, _) {
        return Scaffold(
          drawer: CustomDrawer(),
          appBar: AppBar(
            actions: [
              IconButton(
                icon: Icon(Icons.logout, color: blackColor),
                onPressed: () {
                  authConsumer.logout();
                },
              ),
            ],
          ),
          body: Column(
            children: [
              AnimatedSwitcher(
                duration: 300.ms,
                child: currentIndex == 0 ? WalletContent() : InvoicesContent(),
              ),
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [],
                ),
              ),

              MainButton(
                onTap: () async {
                  bool? isUploded = await showDialog(
                    context: context,
                    builder: (context) => PickImageDialog(),
                  );
                  if (isUploded == true && context.mounted) {
                    showCustomFlushBar(
                      context,
                      "Image uploaded successfully!",
                      "thank you for waiting.",
                      true,
                    );
                  } else if (isUploded == false && context.mounted) {
                    showCustomFlushBar(
                      context,
                      "Image uploaded failed!",
                      "please try again.",
                      false,
                    );
                  } else if (isUploded == null && context.mounted) {
                    showCustomFlushBar(
                      context,
                      "Image upload cancelled!",
                      "no image was selected.",
                      false,
                    );
                  }
                },
                title: "Upload a picture",
              ),

              qrConsumer.qrs.isNotEmpty
                  ? Expanded(
                      child: ListView.builder(
                        itemCount: qrConsumer.qrs.length,
                        itemBuilder: (BuildContext context, int index) {
                          return ListTile(title: Text(qrConsumer.qrs[index]));
                        },
                      ),
                    )
                  : SizedBox(),
            ],
          ),

          floatingActionButtonLocation: FloatingActionButtonLocation.endFloat,
          floatingActionButton: FloatingActionButton(
            backgroundColor: primaryColor,
            child: Icon(Icons.qr_code, color: whiteColor),
            onPressed: () async {
              // TODO QR Functionality DONE;
              final scannedCode = await Navigator.of(context).push(
                MaterialPageRoute(builder: (context) => const QrScanner()),
              );
              if (scannedCode != null) {
                bool isValid = await qrConsumer.validateTransaction();
                if (isValid && context.mounted) {
                  showCustomFlushBar(
                    context,
                    "The transaction is valid!",
                    "it will be processed shortly.",
                    true,
                  );
                }
              }
            },
          ),
        );
      },
    );
  }
}
