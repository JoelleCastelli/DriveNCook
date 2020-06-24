package javafx;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class Promotion {
    private final StringProperty id;
    private final StringProperty userId;
    private final StringProperty promoType;
    private final StringProperty value;

    public Promotion() {
        this(null, null, null, null);
    }

    public Promotion(String id, String userId, String promoType, String value) {
        this.id = new SimpleStringProperty(id);
        this.userId = new SimpleStringProperty(userId);
        this.promoType = new SimpleStringProperty(promoType);
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

    public String getUserId() {
        return userId.get();
    }

    public StringProperty userIdProperty() {
        return userId;
    }

    public void setUserId(String userId) {
        this.userId.set(userId);
    }

    public String getPromoType() {
        return promoType.get();
    }

    public StringProperty promoTypeProperty() {
        return promoType;
    }

    public void setPromoType(String promoType) {
        this.promoType.set(promoType);
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
