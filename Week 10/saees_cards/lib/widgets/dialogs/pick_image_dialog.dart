import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:saees_cards/providers/upload_image_provider.dart';
import 'package:saees_cards/widgets/cickables/main_button.dart';

class PickImageDialog extends StatelessWidget {
  const PickImageDialog({super.key});

  @override
  Widget build(BuildContext context) {
    return Consumer<UploadImageProvider>(
      builder: (context, imageConsumer, _) {
        return AlertDialog(
          title: Center(child: Text("Pick Image")),
          content: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisSize: MainAxisSize.min,
            children: [
              MainButton(
                busy: imageConsumer.busy,
                horizontalPadding: 0,
                onTap: () async {
                  await imageConsumer.fromGallery();
                  if (context.mounted) {
                    Navigator.pop(context, imageConsumer.uploadCompleted);
                  }
                },
                title: "From Gallery",
              ),

              MainButton(
                busy: imageConsumer.busy,
                horizontalPadding: 0,
                onTap: () async {
                  await imageConsumer.takePhoto();
                  if (context.mounted) {
                    Navigator.pop(context, imageConsumer.uploadCompleted);
                  }
                  // if (context.mounted &&
                  //     imageConsumer.uploadCompleted == true) {
                  //   showCustomFlushBar(
                  //     context,
                  //     "Image uploaded successfully!",
                  //     "",
                  //     true,
                  //   );
                  // }
                },
                title: "Take a Photo",
              ),
            ],
          ),
        );
      },
    );
  }
}
