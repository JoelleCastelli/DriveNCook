//
// Created by nou on 31/03/2020.
//

#include "gtkFunctions.h"

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void on_subscribeButton_clicked() {
    printf("Subscribe clicked !\n");
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void startGTK(int *argc, char ***argv) {
    gtk_init(argc, argv);
    builder = gtk_builder_new_from_file(gladeFile);
    connectWidgets();

    connectSignals();
    g_object_unref(builder);

    gtk_widget_show_all(widgets->window);

    gtk_main();

    g_slice_free(AppWidgets, widgets);
}

void connectWidgets() {
    widgets = g_slice_new(AppWidgets);

    widgets->window = GTK_WIDGET(gtk_builder_get_object(builder, "window"));
    widgets->subscribeButton = GTK_BUTTON(gtk_builder_get_object(builder, "subscribeButton"));
    widgets->nameEntry = GTK_ENTRY(gtk_builder_get_object(builder, "nameEntry"));
    widgets->firstNameEntry = GTK_ENTRY(gtk_builder_get_object(builder, "firstNameEntry"));
    widgets->emailEntry = GTK_ENTRY(gtk_builder_get_object(builder, "emailEntry"));
    widgets->statusLabel = GTK_LABEL(gtk_builder_get_object(builder, "statusLabel"));
}

void connectSignals() {
    g_signal_connect(widgets->window, "destroy", G_CALLBACK(onDestroy), NULL);
    gtk_builder_add_callback_symbol(builder, "on_subscribeButton_clicked", G_CALLBACK(on_subscribeButton_clicked));
    gtk_builder_connect_signals(builder, NULL);
}

void onDestroy() {
    gtk_main_quit();
}