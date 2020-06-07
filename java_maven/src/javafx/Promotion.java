package javafx;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class Promotion {
    private final StringProperty id;
    private final StringProperty user_id;
    private final StringProperty promo_type;
    private final StringProperty value;

    public Promotion() {
        this(null, null, null, null);
    }

    public Promotion(String id, String user_id, String promo_type, String value) {
        this.id = new SimpleStringProperty(id);
        this.user_id = new SimpleStringProperty(user_id);
        this.promo_type = new SimpleStringProperty(promo_type);
        this.value = new SimpleStringProperty(value);
    }

    public String getId() {
        return id.get();
    }

    public StringProperty idProperty() {
        return id;
    }

    public void setId(String id) {
        this.id.set(id);
    }

    public String getUser_id() {
        return user_id.get();
    }

    public StringProperty user_idProperty() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id.set(user_id);
    }

    public String getPromo_type() {
        return promo_type.get();
    }

    public StringProperty promo_typeProperty() {
        return promo_type;
    }

    public void setPromo_type(String promo_type) {
        this.promo_type.set(promo_type);
    }

    public String getValue() {
        return value.get();
    }

    public StringProperty valueProperty() {
        return value;
    }

    public void setValue(String value) {
        this.value.set(value);
    }
}
