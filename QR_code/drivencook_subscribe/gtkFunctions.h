//
// Created by nou on 31/03/2020.
//

#ifndef DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H
#define DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H

#include <gtk-3.0/gtk/gtk.h>

GtkBuilder *builder;
extern char *gladeFile;

typedef struct {
    GtkWidget *window;
    GtkButton *subscribeButton;
    GtkEntry *nameEntry;
    GtkEntry *firstNameEntry;
    GtkEntry *emailEntry;
    GtkLabel *statusLabel;

} AppWidgets;

AppWidgets *widgets;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

G_MODULE_EXPORT void on_subscribeButton_clicked();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


void startGTK(int *argc, char ***argv);

void connectWidgets();

void onDestroy();

#endif //DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H
