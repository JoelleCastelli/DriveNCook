//
// Created by nou on 31/03/2020.
//

#include "gtkFunctions.h"

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void on_subscribeButton_clicked() {
    const char *name = gtk_entry_get_text(widgets->nameEntry);
    const char *firstName = gtk_entry_get_text(widgets->firstNameEntry);
    const char *email = gtk_entry_get_text(widgets->emailEntry);

    char *errorMessage = checkInputs(name, firstName, email);

    if (strlen(errorMessage) > 0) {
        errorStatus(errorMessage);
        return;
    }
    status("En cours de traitement...");


}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void startGTK(int *argc, char ***argv) {
    gtk_init(argc, argv);
    builder = gtk_builder_new_from_file(gladeFile);
    connectWidgets();

    connectSignals();
    g_object_unref(builder);

    gtk_widget_show_all(widgets->window);
    status("En attente d'entrée utilisateur...");
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

void status(char *statusMessage) {
    gtk_label_set_label(widgets->statusLabel, statusMessage);
}

void successStatus(char *statusMessage) {
    char markupBuffer[255];
    sprintf(markupBuffer, "<span foreground='green'>%s</span>", statusMessage);
    gtk_label_set_markup(widgets->statusLabel, markupBuffer);
}

void errorStatus(char *statusMessage) {
    char markupBuffer[255];
    sprintf(markupBuffer, "<span foreground='red'>%s</span>", statusMessage);
    gtk_label_set_markup(widgets->statusLabel, markupBuffer);
}

char *checkInputs(const char *name, const char *firstName, const char *email) {
    char *errorMessage;
    errorMessage = malloc(1);
    strcpy(errorMessage, "");


    if (strlen(name) == 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 15 + 1);
        strcat(errorMessage, "Nom incorrect. ");
    }
    if (strlen(firstName) == 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 18 + 1);
        strcat(errorMessage, "Prénom incorrect. ");
    }

    if (strlen(email) == 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 17 + 1);
        strcat(errorMessage, "Email incorrect. ");
    }

    return errorMessage;
}

